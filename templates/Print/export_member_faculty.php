<?php
// Load PHPExcel library
require_once 'PHPExcel/PHPExcel.php';

// Create a new PHPExcel object
$excel = new PHPExcel();

// Set properties of the Excel document
$excel->getProperties()->setTitle("Admin Member Report");
$excel->getActiveSheet()->setTitle("Member Data");

// Add data to the Excel sheet
$excel->getActiveSheet()
    ->setCellValue('A1', '#')
    ->setCellValue('B1', 'LIBRARY ID')
    ->setCellValue('C1', 'MEMBER NAME')
    ->setCellValue('D1', 'FACULTY STATUS')
    ->setCellValue('E1', 'OFFICE')
    ->setCellValue('F1', 'DATE');

$ctr = 1;
$row = 2;

foreach ($datas as $data) {
    $ctr++;
    $excel->getActiveSheet()
        ->setCellValue('A' . $row, $ctr)
        ->setCellValue('B' . $row, $data['library_id_number'])
        ->setCellValue('C' . $row, $data['employee_name'])
        ->setCellValue('D' . $row, $data['faculty_status'])
        ->setCellValue('E' . $row, $data['office'])
        ->setCellValue('F' . $row, $data['date']);
    
    $row++;
}

// Apply basic styling to header row
$headerStyle = array(
    'font' => array('bold' => true),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'D9E1F2'))
);

$excel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($headerStyle);

// Create and save Excel file
$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Admin_Member.xls"');
$writer->save('php://output');
exit;
?>
