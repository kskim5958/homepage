<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';

$functionName = $_POST['functionName'];

switch ($functionName) {
    case 'recall_insert':
        recall_insert();
        break;
    default:
        break;
}

function recall_insert() {
    global $mysqli;
    $userNo = $_POST['userNo'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO RECALL VALUES (NULL, $userNo, CURRENT_TIMESTAMP, $status, \"$comment\");";
    if ($mysqli->query($sql)) {
        # 성공하면 리콜목록 가져오기
        $json = json_encode(['result'=>true, 'list'=>recall_list($userNo)]);
    } else {
        # 실패하면 자바스크립트에 알림
        $json = json_encode(['result'=>false, 'error'=>"recall insert :{$mysqli->errno}"]);
    }
    echo $json;
}

function recall_list($userNo) {
    global $mysqli;
    $sql = "SELECT * FROM RECALL WHERE userNo = $userNo ORDER BY recallDate DESC;";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'userNo'=>$row['userNo']
            ,'recallDate'=>$row['recallDate']
            ,'status'=>$row['status']
            ,'comment'=>$row['comment']
        ];
    }
    return $list;
}