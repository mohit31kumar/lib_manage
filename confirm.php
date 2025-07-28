<?php
session_start();
require 'db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
$entryTime = date("H:i:s");

// Prepare log file
$today = date("Y-m-d");
$logFile = _DIR_ . "/logs/log_$today.xlsx";

// Load or create spreadsheet
if (file_exists($logFile)) {
    $spreadsheet = IOFactory::load($logFile);
    $sheet = $spreadsheet->getActiveSheet();
} else {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // Set header
    $sheet->fromArray(['Full Reg No', 'Name', 'Branch', 'Year', 'Email', 'Entry Time', 'Exit Time'], NULL, 'A1');
}

// Find the next empty row
$row = $sheet->getHighestRow() + 1;

// Check if student already entered (for exit time)
$found = false;
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
    $cellValue = $sheet->getCell("A$i")->getValue();
    if ($cellValue == $fullReg && $sheet->getCell("G$i")->getValue() === null) {
        // Set exit time
        $sheet->setCellValue("G$i", $entryTime);
        $found = true;
        break;
    }
}

// If not found, it's a fresh entry
if (!$found) {
    $sheet->fromArray([$fullReg, $name, $branch, $year, $email, $entryTime, null], NULL, "A$row");
}

// Save the file
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($logFile);

// Clear session
session_destroy();

// Redirect back with entry message
header("Location: index.html?entry=" . urlencode($name));
exit();
?>