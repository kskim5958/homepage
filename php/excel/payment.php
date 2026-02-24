<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// 엑셀 파일 경로
$inputFileName = $_SERVER["DOCUMENT_ROOT"] . '/php/excel/2026-02-24진료비통계.xlsx';

// 엑셀 파일 타입에 맞춰 자동으로 리더 생성
$spreadsheet = IOFactory::load($inputFileName);

// 첫 번째 시트 선택
$sheet = $spreadsheet->getSheet(1);

// 전체 데이터를 배열로 변환
$data = $sheet->toArray();

// 데이터 출력
foreach ($data as $index => $row) {
    if ($index == 0) {
        $title_row = $row;
    } else {
        $user_row[] = $row;
    }
}

function num($val) {
    $result = preg_replace("/[^0-9-]/", "", $val);
    return (int)$result;
}

// [0] : 순번  [1] : 진료일  [2] : 차트번호    [3] : 이름  [4] : 보험구분    [5] : 수입집계  [6] : 진료의사    [7] : 어시스트  [8] : 당일접수
// [9] : 수납자    [10] : 총진료비 [11] : 청구액    [12] : 본인부담금   [13] : 비급여  [14] : 부가가치세 [15] : 할인액    [16] : 총수납액
// [17] : 카드수납  [18] : 현금수납   [19] : 기타(온라인)    [20] : 현영발행액   [21] : 건강생활유지비승인
// [22] : 미수(+)선수(-) [23] : 총미수/선수   [24] : 진료비구분  [25] : 진료내역   [26] : 메모    [27] : 최초내원 [28] : 내원경로

foreach ($user_row as $row) {
    foreach ($row as $key => $value) {
        echo "[{$key}] : [{$value}]" . "<br>";
    }
}
?>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>