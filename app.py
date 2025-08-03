from flask import Flask, render_template, request, redirect, url_for, flash, session
import pandas as pd
import os

app = Flask(__name__)
app.secret_key = 'your_secret_key'

USER_FILE = 'users.xlsx'

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/check', methods=['POST'])
def check_user():
    registry_code = request.form.get('registry_last5', '').strip()

    # Validate 5-digit input
    if not registry_code or not registry_code.isdigit() or len(registry_code) != 5:
        flash("❌ Please enter a valid 5-digit registration code.")
        return redirect(url_for('index'))

    # Check if file exists
    if not os.path.exists(USER_FILE):
        flash("❌ User database file not found.")
        return redirect(url_for('index'))

    try:
        df = pd.read_excel(USER_FILE)
        required_columns = {'full_reg_no', 'name', 'branch', 'year', 'email'}
        if not required_columns.issubset(df.columns):
            flash("❌ User database file is missing required columns.")
            return redirect(url_for('index'))

        user_row = df[df['full_reg_no'].astype(str).str[-5:] == registry_code]

        if user_row.empty:
            flash("❌ No user found with these 5 digits.")
            return redirect(url_for('index'))

        user = user_row.iloc[0]
        # Instead of redirecting, render the index.html with user info
        return render_template('index.html', user={
            'full_reg_no': user['full_reg_no'],
            'name': user['name'],
            'branch': user['branch'],
            'year': int(user['year']),
            'email': user['email']
        })

    except Exception as e:
        flash(f"⚠️ Error: {str(e)}")
        return redirect(url_for('index'))


@app.route('/confirm_user', methods=['POST'])
def confirm_user():
    full_reg_no = request.form.get('full_reg_no')

    if not full_reg_no:
        flash("❌ Missing registration number.")
        return redirect(url_for('index'))

    try:
        # Read from users.xlsx
        df_users = pd.read_excel(USER_FILE)
        user_row = df_users[df_users['full_reg_no'] == full_reg_no]
        if user_row.empty:
            flash("❌ User not found.")
            return redirect(url_for('index'))

        user = user_row.iloc[0]

        # Read or create library_log.xlsx
        log_path = 'library_log.xlsx'
        if os.path.exists(log_path):
            df_logs = pd.read_excel(log_path)
        else:
            df_logs = pd.DataFrame(columns=['id', 'full_reg_no', 'name', 'branch', 'year', 'email', 'entry_time', 'exit_time'])

        # Check if user already has an open log
        open_log = df_logs[(df_logs['full_reg_no'] == full_reg_no) & (df_logs['exit_time'].isna())]

        from datetime import datetime
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        if not open_log.empty:
            # Update exit_time
            idx = open_log.index[0]
            df_logs.at[idx, 'exit_time'] = now
            action = 'exited'
        else:
            # Add new entry
            new_id = df_logs['id'].max() + 1 if not df_logs.empty else 1
            df_logs = pd.concat([df_logs, pd.DataFrame([{
                'id': int(new_id),
                'full_reg_no': user['full_reg_no'],
                'name': user['name'],
                'branch': user['branch'],
                'year': user['year'],
                'email': user['email'],
                'entry_time': now,
                'exit_time': ''
            }])], ignore_index=True)
            action = 'entered'

        # Save log
        df_logs.to_excel(log_path, index=False)

        # Redirect back with message
        return redirect(url_for('index', msg=f"{user['name']} {action} the library"))

    except Exception as e:
        flash(f"⚠️ Error during log confirmation: {str(e)}")
        return redirect(url_for('index'))


if __name__ == "__main__":
    app.run(debug=True)
