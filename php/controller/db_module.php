<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';

if (isset($_POST['functionName'])) {
    switch ($_POST['functionName']) {
        case 'member_update':
            member_update();
            break;
        case 'recall_insert':
            recall_insert();
            break;
        case 'recall_update':
            recall_update();
            break;
        default:
            break;
    }
}

function member_select($userNo) {
    global $mysqli;
    /** @var mysqli $mysqli */
    $sql = "SELECT * FROM  VISIT WHERE no = $userNo;";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function member_update() {
    global $mysqli;
    $userNo = $_POST['userNo'];
    $status = $_POST['status'];
    $sql = "UPDATE VISIT SET status = $status WHERE no = $userNo";

    if ($mysqli->query($sql)) {
        # 성공하면 리콜목록 가져오기
        $json = json_encode(['result'=>true, 'list'=>member_select($userNo)]);
    } else {
        # 실패하면 자바스크립트에 알림
        $json = json_encode(['error'=>"member select false: $mysqli->errno"]);
    }
    echo $json;
}

function member_list($start, $list_num) {
    global $mysqli;
    $list = [];
    $sql = "SELECT * FROM  VISIT ORDER BY no DESC LIMIT $start, $list_num;";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'visitDate'=>$row['visitDate']
            ,'status'=>$row['status']
            ,'userName'=>$row['userName']
            ,'userPhone'=>$row['userPhone']
            ,'path'=>$row['path']
            ,'ip'=>$row['ip']
        ];
    }
    return $list;
}

function recall_list($userNo) {
    global $mysqli;
    $list = [];
    $sql = "SELECT * FROM RECALL WHERE status = 0 AND userNo = $userNo ORDER BY recallDate DESC;";
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

function recall_insert() {
    global $mysqli;
    $userNo = $_POST['userNo'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO RECALL (userNo, recallDate ,comment) VALUES ($userNo, CURRENT_TIMESTAMP, \"$comment\");";
    if ($mysqli->query($sql)) {
        # 성공하면 리콜목록 가져오기
        $json = json_encode(['result'=>true, 'list'=>recall_list($userNo)]);
    } else {
        # 실패하면 자바스크립트에 알림
        $json = json_encode(['error'=>"recall insert false: $mysqli->errno"]);
    }
    echo $json;
}

function recall_update() {
    global $mysqli;
    $recallNo = $_POST['recallNo'];
    $userNo = $_POST['userNo'];
    $sql = "UPDATE RECALL SET status = 1 WHERE no = $recallNo";
    if ($mysqli->query($sql)) {
        # 성공하면 리콜목록 가져오기
        $json = json_encode(['result'=>true, 'list'=>recall_list($userNo)]);
    } else {
        # 실패하면 자바스크립트에 알림
        $json = json_encode(['error'=>"recall update false: $mysqli->errno"]);
    }
    echo $json;
}

function comment_type_list() {
    global $mysqli;
    $list = [];
    $sql ='SELECT * FROM COMMENT_TYPE ORDER BY no ASC';
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'comment'=>$row['comment']
        ];
    }
    return $list;
}
function member_type_list() {
    global $mysqli;
    $list = [];
    $sql ='SELECT * FROM MEMBER_TYPE ORDER BY no ASC';
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'comment'=>$row['comment']
        ];
    }
    return $list;
}