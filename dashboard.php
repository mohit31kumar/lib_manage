<?php
session_start();
if (!isset($_SESSION['full_reg_no'])) {
    header("Location: ../index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../dashboardstyle.css">
    <style>
        /* Dashboard Page Styles */

        body {
            margin: 0;
            padding: 0;
            background-color: #ecff9e;
            font-family: "Noto Sans", sans-serif !important;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            position: relative;
            z-index: 1;
            background-color: #ffffff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #333;
        }

        .photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #007bff;
        }

        .info-field {
            margin-bottom: 15px;
            text-align: left;
        }

        .info-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #444;
        }

        .info-field input {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

       .confirm-btn {
    margin-top: 20px;
    background-color: #3235ecff;
    color: white;
    text-decoration: none;
    display: inline-block;
    padding: 12px 28px;
    font-size: 16px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

.confirm-btn:hover {
    background-color: #3235ecff;
}

    </style>
</head>

<body>

    <div class="container">
        <h2>Welcome <?= htmlspecialchars($_SESSION['name']); ?>, confirm your details</h2>

        <!-- Optional user photo -->
        <!-- <img src="path-to-photo.jpg" alt="User Photo" class="photo"> -->

        <div class="info-field">
            <label>Full Registration Number</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['full_reg_no']); ?>" readonly>
        </div>

        <div class="info-field">
            <label>Branch</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['branch']); ?>" readonly>
        </div>

        <div class="info-field">
            <label>Year</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['year']); ?>" readonly>
        </div>

        <div class="info-field">
            <label>Email</label>
            <input type="text" value="<?= htmlspecialchars($_SESSION['email']); ?>" readonly>
        </div>

        <form action="confirm.php" method="POST">
    <button type="submit" name="confirm" value="1">Confirm</button>
</form>


    </div>

</body>

</html>