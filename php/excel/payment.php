<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
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
    return (int)$result;
}

// [0] : 순번  [1] : 진료일  [2] : 차트번호    [3] : 이름  [4] : 보험구분    [5] : 수입집계  [6] : 진료의사    [7] : 어시스트  [8] : 당일접수
// [9] : 수납자    [10] : 총진료비 [11] : 청구액    [12] : 본인부담금   [13] : 비급여  [14] : 부가가치세 [15] : 할인액    [16] : 총수납액
// [17] : 카드수납  [18] : 현금수납   [19] : 기타(온라인)    [20] : 현영발행액   [21] : 건강생활유지비승인
// [22] : 미수(+)선수(-) [23] : 총미수/선수   [24] : 진료비구분  [25] : 진료내역   [26] : 메모    [27] : 최초내원 [28] : 내원경로
?>
<div id="content__list">
    <section class="content__outer payment">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">순번</th>
                    <th rowspan="2" colspan="2">성명</th>
                    <th colspan="3">보험수납</th>
                    <th colspan="3">비보험수납</th>
                    <th rowspan="2">보험미수</th>
                </tr>
                <tr>
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
                    $pay_ls = ["cash" => $cash, "card" => $card, "online" => $online];
                    $pay_sum = array_sum($pay_ls);
                    
                    if ($ins == $pay_sum) {
                        foreach ($pay_ls as $key => $value) {
                            if ($pay_ls[$key] != 0) {
                                $ins = $ins - $pay_ls[$key];
                                $ins_pay_ls[] = [$key => $value];
                            }
                        }
                    }
                    if ($unins == $pay_sum) {
                        foreach ($pay_ls as $key => $value) {
                            if ($pay_ls[$key] != 0) {
                                $unins = $unins - $pay_ls[$key];
                                $unins_pay_ls[] = [$key => $value];
                            }
                        }
                    }

                    // echo "<tr>";
                    // echo "<td>". ($index + 1) . "</td>";
                    // echo "<td colspan=\"2\">{$user[2]} {$user[3]}</td>";
                    // echo "<td>{$ins_cash}</td>";
                    // echo "<td>{$ins_card}</td>";
                    // echo "<td>{$ins_online}</td>";
                    // echo "<td>{$unins_cash}</td>";
                    // echo "<td>{$unins_card}</td>";
                    // echo "<td>{$unins_online}</td>";
                    // echo "<td>{$ins_diff}</td>";
                    // echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>