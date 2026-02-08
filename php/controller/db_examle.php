<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';

$query = "SELECT user_no, SUM(estimate) AS estimate, SUM(payment) AS payment FROM `AMOUNT` WHERE update_no = 0 AND user_no = 885 GROUP BY user_no;";
$result = $mysqli->query($query);
$column = [];
$column[] = $result->fetch_assoc();

var_dump($column);

$query = "SELECT * FROM `AMOUNT` WHERE update_no = 0 AND user_no = 885 ORDER BY reg_dt DESC;";
$result = $mysqli->query($query);

$list = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }
}
var_dump(count($list));