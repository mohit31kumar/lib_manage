<?php
$host = "localhost";   // Database host
$user = "root";        // MySQL username
$pass = "";            // MySQL password
$dbname = "library_db"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
