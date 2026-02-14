<?php
include $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// 엑셀 파일 경로
$inputFileName = $_SERVER["DOCUMENT_ROOT"] . '/php/excel/2026-02-13진료비통계.xlsx';

// 엑셀 파일 타입에 맞춰 자동으로 리더 생성
$spreadsheet = IOFactory::load($inputFileName);

// 첫 번째 시트 선택
$sheet = $spreadsheet->getActiveSheet();

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
    return $result;
}

// [0] : 순번  [1] : 진료일  [2] : 차트번호    [3] : 이름  [4] : 보험구분    [5] : 수입집계  [6] : 진료의사    [7] : 어시스트  [8] : 당일접수
// [9] : 수납자    [10] : 총진료비 [11] : 청구액    [12] : 본인부담금   [13] : 비급여  [14] : 부가가치세 [15] : 할인액    [16] : 총수납액
// [17] : 카드수납  [18] : 현금수납   [19] : 기타(온라인)    [20] : 현영발행액   [21] : 건강생활유지비승인
// [22] : 미수(+)선수(-) [23] : 총미수/선수   [24] : 진료비구분  [25] : 진료내역   [26] : 메모    [27] : 최초내원 [28] : 내원경로
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <!-- <th><?php echo $title_row[1] ?></th> -->
                <!-- <th colspan="2"><?php echo "{$title_row[2]}/{$title_row[3]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[10]}" ?></th> -->
                <!-- <th><?php echo "보험 {$title_row[11]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[12]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[13]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[16]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[17]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[18]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[19]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[20]}" ?></th> -->
                <!-- <th><?php echo "{$title_row[28]}" ?></th> -->
                 <th>순번</th>
                 <th colspan="2">성명</th>
                 <th>현금</th>
                 <th>카드</th>
                 <th>계좌이체</th>
                 <th>현금</th>
                 <th>카드</th>
                 <th>계좌이체</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($user_row as $index => $user) {
                    $cash = num($user[18]);
                    $card = num($user[17]);
                    $online = num($user[19]);
                    $ins = num($user[12]);
                    $unins = num($user[13]);
                    $ins = ($ins == 0 || $ins == "") ? 0 : $ins;
                    $unins = ($unins == 0 || $unins == "") ? 0 : $unins;
                    $ins_sum = $ins + $unins;
                    $pay_sum = $cash + $card + $online;

                    $ins_cash = 0;
                    $ins_card = 0;
                    $ins_online = 0;
                    $unins_cash = 0;
                    $unins_card = 0;
                    $unins_online = 0;
                    $diff = 0;
                    
                    if ($ins != 0) {
                        switch ($ins) {
                            case $ins == $cash:
                                $ins_cash = $cash;
                                break;
                            case $ins == $cash:
                                $ins_cash = $cash;
                                break;
                            case $ins == $cash:
                                $ins_cash = $cash;
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    echo "<tr>";
                    echo "<td>". ($index + 1) . "</td>";
                    echo "<td colspan=\"2\">{$user[2]} {$user[3]}</td>";
                    echo "<td>{$cash}</td>";
                    echo "<td>{$card}</td>";
                    echo "<td>{$online}</td>";
                    echo "<td>{$cash}</td>";
                    echo "<td>{$card}</td>";
                    echo "<td>{$online}</td>";
                    echo "</tr>";
                }
            ?>

            <tr></tr>
        </tbody>
    </table>
</body>
</html>