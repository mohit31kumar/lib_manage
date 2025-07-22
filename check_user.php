<?php
session_start();
require 'db.php';

$last5 = $_POST['registry_last5'] ?? '';

// 1️⃣ Find user in users table
$sql = "SELECT * FROM users WHERE RIGHT(full_reg_no, 5) = '$last5' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullReg = $user['full_reg_no'];

    // 2️⃣ Check if an open log exists (exit_time is NULL)
    $checkLog = $conn->query("
        SELECT id FROM library_log 
        WHERE full_reg_no = '$fullReg' 
        AND exit_time IS NULL LIMIT 1
    ");

    if ($checkLog->num_rows > 0) {
        // ✅ EXIT → update exit_time & redirect with message
        $logId = $checkLog->fetch_assoc()['id'];
        $conn->query("UPDATE library_log SET exit_time = NOW() WHERE id = $logId");
        header("Location: index.html?exit=" . urlencode($user['name']));
        exit();

    } else {
        // ✅ ENTRY → only set session, DO NOT insert log yet
        $_SESSION['name']        = $user['name'];
        $_SESSION['full_reg_no'] = $user['full_reg_no'];
        $_SESSION['branch']      = $user['branch'];
        $_SESSION['year']        = $user['year'];
        $_SESSION['email']       = $user['email'];

        // Redirect to dashboard for confirmation
        header("Location: dashboard.php");
        exit();
    }

} else {
    // ❌ INVALID → redirect with error
    header("Location: index.html?error=1");
    exit();
}
?>
