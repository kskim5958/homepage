<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/common_module.php';

if (isset($_POST['functionName'])) {
    switch ($_POST['functionName']) {
        case 'user_insert':
            user_insert();
            break;
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

function user_statistics() {
    global $mysqli;
    $sql = "
    SELECT 
        COUNT(*) as total,
        COUNT(IF(status = 1 OR status = 2 OR status = 3 OR status = 4 OR status = 5 , 1, NULL)) as big_total,
        COUNT(IF(status = 1, 1, NULL)) as big_qutcall,
        COUNT(IF(status = 2, 1, NULL)) as big_completed,
        COUNT(IF(status = 3, 1, NULL)) as big_agree,
        COUNT(IF(status = 4, 1, NULL)) as big_not_agree,
        COUNT(IF(status = 5, 1, NULL)) as big_cancel,
        COUNT(IF(status = 6, 1, NULL)) as in_introduction,
        COUNT(IF(status = 7, 1, NULL)) as in_internet,
        COUNT(IF(status = 8, 1, NULL)) as in_other,
        SUM(cost) as total_cost,
        SUM(IF(status = 1 OR status = 2 OR status = 3 OR status = 4 OR status = 5 , cost, 0)) as big_total_cost,
        SUM(CASE WHEN status = 1 THEN cost ELSE 0 END) as big_outcall_cost,
        SUM(CASE WHEN status = 2 THEN cost ELSE 0 END) as big_completed_cost,
        SUM(CASE WHEN status = 3 THEN cost ELSE 0 END) as big_agree_cost,
        SUM(CASE WHEN status = 4 THEN not_decided ELSE 0 END) as big_not_agree_cost,
        SUM(CASE WHEN status = 5 THEN cost ELSE 0 END) as big_cancel_cost,
        SUM(CASE WHEN status = 6 THEN cost ELSE 0 END) as in_introduction_cost,
        SUM(CASE WHEN status = 7 THEN cost ELSE 0 END) as in_internet_cost,
        SUM(CASE WHEN status = 8 THEN cost ELSE 0 END) as in_other_cost
    FROM (SELECT *, COUNT(userPhone) FROM VISIT GROUP BY userPhone HAVING COUNT(userPhone) >= 1 ORDER BY cost DESC) NEW_VISIT;
    ";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function user_insert() {
    global $mysqli;
    $userName = $_POST['userName'];
    $userPhone = $_POST['userPhone'];
    $sql = "INSERT INTO VISIT (userName, userPhone, visitDate) VALUES (\"$userName\", \"$userPhone\", CURRENT_TIMESTAMP);";
    if ($mysqli->query($sql)) {
        echo json_encode(['result'=>true, 'url'=>http_path(), 'arr'=>member_select($mysqli->insert_id)]);
    } else {
        echo json_encode(['result'=>false, 'error'=> "user insert 에러 : $mysqli->error"]);
    }
}

function member_select($userNo) {
    global $mysqli;
    $sql = "SELECT * FROM  VISIT WHERE no = $userNo;";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function member_update() {
    global $mysqli;
    $userNo = $_POST['userNo'];
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $sql = "UPDATE VISIT SET status = $status WHERE no = $userNo";
    } elseif (isset($_POST['userName'])) {
        $userName = $_POST['userName'];
        $sql = "UPDATE VISIT SET userName = \"$userName\" WHERE no = $userNo";
    } elseif (isset($_POST['cost'])) {
        $cost = $_POST['cost'];
        $sql = "UPDATE VISIT SET cost = $cost WHERE no = $userNo";
    } elseif (isset($_POST['not_decided'])) {
        $not_decided = $_POST['not_decided'];
        $sql = "UPDATE VISIT SET not_decided = $not_decided WHERE no = $userNo";
    } else {
        return;
    }

    if ($mysqli->query($sql)) {
        # 성공하면 리콜목록 가져오기
        $json = json_encode(['result'=>true, 'list'=>member_select($userNo)]);
    } else {
        # 실패하면 자바스크립트에 알림
        $json = json_encode(['error'=>"member select false: $mysqli->errno"]);
    }
    echo $json;
}

function users($start=0, $list_num=0, $params=[]) {
    global $mysqli;
    $param_str = "";
    $list = [];
    $limit =  ($start==0 && $list_num==0) ? "" : "LIMIT $start, $list_num";
    if (count($params) != 0) {
        $param_str .= "WHERE";
        foreach ($params as $key => $value) {
            if ($key == 'search_type' || $key == 'search_text') {
                continue;
            }
            $param_str = "$param_str $key LIKE \"%$value%\"";
        }
    }
    $sql = "
        SELECT
        *
        FROM
        (SELECT
        R_USERS.user_no AS user_no,
        R_USERS.reg_dt AS reg_dt,
        R_USERS.user_name AS user_name,
        R_USERS.user_phone AS user_phone,
        R_USERS.device AS device,
        R_USERS.ip AS ip,
        R_USERS.path AS path,
        R_USERS.status AS status,
        IFNULL(R_AMOUNT.estimate, 0) AS estimate,
        IFNULL(R_AMOUNT.payment, 0) AS payment
        FROM
        (SELECT * FROM `USERS` GROUP BY `user_phone` ORDER BY reg_dt DESC) AS R_USERS
        LEFT JOIN
        (SELECT user_no, SUM(estimate) AS estimate, SUM(payment) AS payment FROM `AMOUNT` GROUP BY `user_no`) AS R_AMOUNT
        ON R_USERS.user_no = R_AMOUNT.user_no) AS USERS $param_str ORDER BY reg_dt DESC $limit;
    ";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            "user_no"=>$row["user_no"],
            "reg_dt"=>$row["reg_dt"],
            "user_name"=>$row["user_name"],
            "user_phone"=>$row["user_phone"],
            "device"=>$row["device"],
            "ip"=>$row["ip"],
            "path"=>$row["path"],
            "status"=>$row["status"],
            "estimate"=>$row["estimate"],
            "payment"=>$row["payment"]
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
function user_type_list() {
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