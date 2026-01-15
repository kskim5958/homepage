<?php
$functionName = $_POST['functionName'];
switch ($functionName) {
    case 'recall_insert':
        recall_insert();
        break;
    default:
        break;
}

function recall_insert() {
    $userNo = $_POST['userNo'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];
    $json = json_encode(array('result' => true, 'userNo' => $userNo));
    echo($json);
}