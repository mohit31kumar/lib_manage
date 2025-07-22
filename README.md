SQL Code to setup database.
only for local host.


## code to setup user table.
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_reg_no VARCHAR(30) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  branch VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(100) NOT NULL
);


##Code to setup log table.
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




##Full setup code to setup tables with entries.

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

-- Optional Index
CREATE INDEX idx_last5 ON users (full_reg_no);

-- Sample Users
INSERT INTO users (full_reg_no, name, branch, year, email) VALUES
('2024PUFCEBMFX19405', 'John Doe', 'CSE', 3, 'john@example.com'),
('2024PUFCEBMFX19406', 'Alice Smith', 'ECE', 2, 'alice@example.com'),
('2024PUFCEBMFX19407', 'Bob Johnson', 'ME', 4, 'bob@example.com');
