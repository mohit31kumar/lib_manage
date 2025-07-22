<?php
session_start();
require 'db.php';

// Ensure user session exists
if (!isset($_SESSION['full_reg_no'])) {
    header("Location: index.html");
    exit();
}

// Get user details from session
$fullReg = $_SESSION['full_reg_no'];
$name    = $_SESSION['name'];
$branch  = $_SESSION['branch'];
$year    = $_SESSION['year'];
$email   = $_SESSION['email'];

// ✅ Insert log now (only once)
$conn->query("
    INSERT INTO library_log 
        (full_reg_no, name, branch, year, email, entry_time)
    VALUES 
        ('$fullReg', '$name', '$branch', $year, '$email', NOW())
");

// Clear session
session_destroy();

// ✅ Redirect back with entry message
header("Location: index.html?entry=" . urlencode($name));
exit();
?>
