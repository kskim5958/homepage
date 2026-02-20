<?php
include $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['file']['name']) {
    $file_tmp = $_FILES['file']['tmp_name'];
    
    try {
        $spreadsheet = IOFactory::load($file_tmp); // 엑셀 파일 로드
        $sheet = $spreadsheet->getSheet(1);
        $data = $sheet->toArray(); // 엑셀 데이터를 배열로 변환

        $r_row = [];
        foreach ($data as $index => $row) {
            if ($index == 0) continue;
            else $r_row[] = $row;
        }
        if (count($r_row) != 0) {
            foreach ($r_row as $index => $value) {
                $name = $r_row[$index][2] . " " . $r_row[$index][3];
                $card = num($r_row[$index][17]);
                $cash = num($r_row[$index][18]);
                $online = num($r_row[$index][19]);
                $unins = num($r_row[$index][13]);
                $ins = ($card + $cash + $online) - $unins;
                $payment_ls[$index] = [
                    "name" => $name,
                    "card" => $card,
                    "cash" => $cash,
                    "online" => $online,
                    "ins" => $ins,
                    "unins" => $unins,
                    "ins_card" => 0,
                    "ins_cash" => 0,
                    "ins_online" => 0,
                    "unins_card" => 0,
                    "unins_cash" => 0,
                    "unins_online" => 0
                ];
                if ($ins > 0) {
                    $var = 0;
                    if ($card > $var) {
                        $var = $card - $ins;
                        $payment_ls[$index]["ins_card"] = ($ins >= $card) ? $card : $ins;
                    }
                    if ($cash > $var) {
                        $var = $cash - $ins;
                        $payment_ls[$index]["ins_cash"] = ($ins >= $cash) ? $cash : $ins;
                    }
                    if ($online > $var) {
                        $var = $online - $ins;
                        $payment_ls[$index]["ins_online"] = ($ins >= $online) ? $online : $ins;
                    }
                }
                if ($unins > 0) {
                    $var = 0;
                    if ($card > $var) {
                        $var = $card - $unins;
                        $payment_ls[$index]["unins_card"] = ($unins >= $card) ? $card : $unins;
                    }
                    if ($cash > $var) {
                        $var = $cash - $unins;
                        $payment_ls[$index]["unins_cash"] = ($unins >= $cash) ? $cash : $unins;
                    }
                    if ($online > $var) {
                        $var = $online - $unins;
                        $payment_ls[$index]["unins_online"] = ($unins >= $online) ? $online : $unins;
                    }
                }
                $payment_ls[$index]["payment_sum"] = $card + $cash + $online;
                $payment_ls[$index]["content"] = $r_row[$index][25];
            }
        }
        $json = json_encode(["result" => true, "list" => $payment_ls, "today" => $r_row[0][1]]);
    } catch (Exception $e) {
        $json = json_encode(["result" => false, "error" => $e->getMessage()]);
    }
    echo $json;
}

function num($val) {
    $result = preg_replace("/[^0-9-]/", "", $val);
    return (int)$result;
}