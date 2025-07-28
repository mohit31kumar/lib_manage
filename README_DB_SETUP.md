# Library Management Database Setup

This README provides SQL commands to set up the required database tables for the Library Management System.

## 1. Create `users` Table

This table stores all registered users.

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_reg_no VARCHAR(30) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  branch VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(100) NOT NULL
);
```

### Sample Users

```sql
INSERT INTO users (full_reg_no, name, branch, year, email) VALUES
('2024PUFCEBMFX19405', 'John Doe', 'CSE', 3, 'john@example.com'),
('2024PUFCEBMFX19406', 'Alice Smith', 'ECE', 2, 'alice@example.com'),
('2024PUFCEBMFX19407', 'Bob Johnson', 'ME', 4, 'bob@example.com');
```

---

## 2. Create `library_log` Table

This table tracks entry & exit times for each library visit.

```sql
CREATE TABLE library_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_reg_no VARCHAR(30) NOT NULL,
  name VARCHAR(100) NOT NULL,
  branch VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(100) NOT NULL,
  entry_time DATETIME NOT NULL,
  exit_time DATETIME DEFAULT NULL
);
```

---

## 3. Optional Index for Faster Search

Since the system searches by the **last 5 digits** of the registration number, you can add an index:

```sql
CREATE INDEX idx_last5 ON users (full_reg_no);
```

---

## Example Log After Use

| id | full_reg_no         | name       | branch | year | email             | entry_time          | exit_time           |
|----|---------------------|------------|--------|------|-------------------|---------------------|---------------------|
| 1  | 2024PUFCEBMFX19405 | John Doe   | CSE    | 3    | john@example.com  | 2025-07-22 10:00:00 | 2025-07-22 12:30:00 |
| 2  | 2024PUFCEBMFX19406 | Alice Smith| ECE    | 2    | alice@example.com | 2025-07-22 11:00:00 | NULL (still inside) |

---

## Quick Setup

Run the following SQL to create everything:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_reg_no VARCHAR(30) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  branch VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(100) NOT NULL
);

CREATE TABLE library_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_reg_no VARCHAR(30) NOT NULL,
  name VARCHAR(100) NOT NULL,
  branch VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(100) NOT NULL,
  entry_time DATETIME NOT NULL,
  exit_time DATETIME DEFAULT NULL
);

CREATE INDEX idx_last5 ON users (full_reg_no);

INSERT INTO users (full_reg_no, name, branch, year, email) VALUES
('2024PUFCEBMFX19405', 'John Doe', 'CSE', 3, 'john@example.com'),
('2024PUFCEBMFX19406', 'Alice Smith', 'ECE', 2, 'alice@example.com'),
('2024PUFCEBMFX19407', 'Bob Johnson', 'ME', 4, 'bob@example.com');
```
