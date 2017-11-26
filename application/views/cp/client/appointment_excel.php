<?php
$excel->setActiveSheetIndex(0)
	->setCellValue('A1', $lang->line('id'))
	->setCellValue('B1', $lang->line('name'))
	->setCellValue('C1', $lang->line('email'))
	->setCellValue('D1', $lang->line('phone'))
	->setCellValue('E1', $lang->line('time'))
	->setCellValue('F1', $lang->line('summary'))
	->setCellValue('G1', $lang->line('content'))
	->setCellValue('H1', $lang->line('state'))
	->setCellValue('I1', $lang->line('updated'))
	->setCellValue('J1', $lang->line('updater'))
;

if (count($list) > 0) {
	$line = 2;
	foreach ($list as $row) {
		$excel->setActiveSheetIndex(0)
			->setCellValue('A' .$line, $row['id'])
			->setCellValue('B' .$line, $row['name'])
			->setCellValue('C' .$line, $row['email'])
			->setCellValue('D' .$line, $row['phone'])
			->setCellValue('E' .$line, $row['time'])
			->setCellValue('F' .$line, $row['summary'])
			->setCellValue('G' .$line, $row['content'])
			->setCellValue('H' .$line, ($lang->line($row['state_name']) ? $lang->line($row['state_name']) : $row['state_name']) .' (' .$row['state_weight'] .')')
			->setCellValue('I' .$line, $row['updated'])
			->setCellValue('J' .$line, $row['updater_name'])
		;
		$line++;
	}
}

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$excel = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$excel->save('php://output');
exit(0);
