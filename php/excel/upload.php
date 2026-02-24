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
                $name = $r_row[$index][3];
                $card = num($r_row[$index][17]);
                $cash = num($r_row[$index][18]);
                $online = num($r_row[$index][19]);
                $unins = num($r_row[$index][13]);
                $payment_sum = $card + $cash + $online;
                $ins = ($payment_sum > 0) ? ($payment_sum - $unins) : 0;
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
                if ($ins > 0 && $payment_sum > 0) {
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
                if ($unins > 0 && $payment_sum > 0) {
                    $var = 0;
                    if ($card > $var)
                        $var = $card - $unins;
                        $payment_ls[$index]["unins_card"] = ($unins >= $card) ? $card : $unins;
                    if ($cash > $var) 
                        $var = $cash - $unins;
                        $payment_ls[$index]["unins_cash"] = ($unins >= $cash) ? $cash : $unins;
                    if ($online > $var) 
                        $var = $online - $unins;
                        $payment_ls[$index]["unins_online"] = ($unins >= $online) ? $online : $unins;
                }
                if ($payment_sum < 0) {
                    ($card < 0) && $payment_ls[$index]["unins_card"] = $card;
                    ($cash < 0) &&$payment_ls[$index]["unins_cash"] = $cash;
                    ($online < 0) && $payment_ls[$index]["unins_online"] = $online;
                }
                $payment_ls[$index]["payment_sum"] = $payment_sum;
                $payment_ls[$index]["content"] = ($r_row[$index][25] == null) ? "-" : $r_row[$index][25];
            }
        }
        if (isset($payment_ls)) {
            $payment_ls_sum["ins_card_sum"] = array_sum(array_column($payment_ls, "ins_card"));
            $payment_ls_sum["ins_cash_sum"] = array_sum(array_column($payment_ls, "ins_cash"));
            $payment_ls_sum["ins_online_sum"] = array_sum(array_column($payment_ls, "ins_online"));
            $payment_ls_sum["unins_card_sum"] = array_sum(array_column($payment_ls, "unins_card"));
            $payment_ls_sum["unins_cash_sum"] = array_sum(array_column($payment_ls, "unins_cash"));
            $payment_ls_sum["unins_online_sum"] = array_sum(array_column($payment_ls, "unins_online"));
            $payment_ls_sum["total_sum"] = array_sum($payment_ls_sum);
            foreach ($payment_ls as $index => $payment) {
                foreach ($payment as $key => $value) {
                    $payment_ls[$index][$key] = is_numeric($payment_ls[$index][$key]) ? number_format($payment_ls[$index][$key]) : $payment_ls[$index][$key];
                }
            }
            foreach ($payment_ls_sum as $key => $value) {
                $payment_ls_sum[$key] = number_format((int)$payment_ls_sum[$key]);
            }
        }
        $json = json_encode([
            "result" => true,
            "list" => isset($payment_ls) ? $payment_ls : [],
            "list_sum" => isset($payment_ls_sum) ? $payment_ls_sum : [],
            "today" => isset($r_row[0][1]) ? $r_row[0][1] : "조회된 날짜가 없습니다."
            ]);
    } catch (Exception $e) {
        $json = json_encode(["result" => false, "error" => $e->getMessage()]);
    }
    echo $json;
}

function num($val) {
    $result = preg_replace("/[^0-9-]/", "", $val);
    return (int) $result;
}