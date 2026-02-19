<?php
include $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['file']['name']) {
    $file_tmp = $_FILES['file']['tmp_name'];
    
    try {
        // 엑셀 파일 로드
        $spreadsheet = IOFactory::load($file_tmp);
        $sheet = $spreadsheet->getSheet(1);
        $data = $sheet->toArray(); // 엑셀 데이터를 배열로 변환

        // HTML 테이블 생성
        echo '<table border="1">';
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars($cell) . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}