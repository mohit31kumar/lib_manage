<?php
require __DIR__. '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

date_default_timezone_set("Asia/Kolkata");

$enrollment = $_POST['enrollment'] ?? '';

$masterFile = __DIR__ . "/master.xlsx";
$logFile = __DIR__ . "/logs/log_" . date("Y-m-d") . ".xlsx";

// Load master data
$spreadsheet = IOFactory::load($masterFile);
$sheet = $spreadsheet->getActiveSheet();
$highestRow = $sheet->getHighestRow();

$name = '';
for ($row = 2; $row <= $highestRow; $row++) {
    $cellValue = $sheet->getCell("B$row")->getValue();
    if ($cellValue == $enrollment) {
        $name = $sheet->getCell("A$row")->getValue();
        break;
    }
}

if ($name == '') {
    echo "<script>alert('Enrollment number not found.'); window.history.back();</script>";
    exit;
}

// Check if log file exists
if (!file_exists($logFile)) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Enrollment');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Entry Time');
    $sheet->setCellValue('D1', 'Exit Time');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($logFile);
}

// Load log sheet
$spreadsheet = IOFactory::load($logFile);
$sheet = $spreadsheet->getActiveSheet();
$logRow = $sheet->getHighestRow() + 1;
$found = false;

// Check for previous entry
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
    if ($sheet->getCell("A$i")->getValue() == $enrollment && $sheet->getCell("D$i")->getValue() == '') {
        // Mark exit
        $sheet->setCellValue("D$i", date("H:i:s"));
        $found = true;
        $message = "Exit marked for $name";
        break;
    }
}

if (!$found) {
    // Mark entry
    $sheet->setCellValue("A$logRow", $enrollment);
    $sheet->setCellValue("B$logRow", $name);
    $sheet->setCellValue("C$logRow", date("H:i:s"));
    $message = "Entry marked for $name";
}

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($logFile);

echo "<script>alert('$message'); window.location.href='index.html';</script>";
?>