<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/common_module.php';

if (isset($_POST["dataArr"])) {
    $dataArr = $_POST["dataArr"];
    $fn = isset($dataArr["fn"]) ? $dataArr["fn"] : "";
    switch ($fn) {
        case "user_update":
            user_update($dataArr);
            break;
        case "new_user_insert":
            new_user_insert($dataArr);
            break;
        case "amount_insert":
            amount_insert($dataArr);
            break;
        case "amount_list":
            amount_list($dataArr);
            break;
        default:
            # code...
            break;
    }
}

// 새로운 user insert
function new_user_insert($dataArr) {
    global $mysqli;
    $user_name = $dataArr["user_name"];
    $user_phone = $dataArr["user_phone"];
    $query = "INSERT INTO `USERS` (user_name, user_phone) VALUES (\"$user_name\", \"$user_phone\");";
    $result = $mysqli->query($query);
    $mysqli->close();
    $json = json_encode(['result' => $result]);
    echo $json;
}

// user 조회
function user_select($user_no) {
    global $mysqli;
    $query = "SELECT
            *,
            CASE 
                WHEN EXISTS (SELECT * FROM `USER_TYPE` AS USER_TYPE WHERE USER_TYPE.no = USERS.status)
                THEN (SELECT USER_TYPE.user_type FROM `USER_TYPE` AS USER_TYPE WHERE USER_TYPE.no = USERS.status LIMIT 1)
                ELSE NULL
            END AS user_comment
            FROM `USERS` AS USERS WHERE user_no = $user_no;";
    $result = $mysqli->query($query);
    $column = $result->fetch_assoc();
    return $column;
}

// user 업데이트
function user_update($dataArr) {
    global $mysqli;
    $user_no = $dataArr["user_no"];
    if (isset($dataArr["status"]))
        $query = "UPDATE USERS SET status = {$dataArr["status"]} WHERE user_no = $user_no";
    if (isset($dataArr["user_name"]))
        $query = "UPDATE USERS SET user_name = \"{$dataArr["user_name"]}\" WHERE user_no = $user_no";
    if (isset($dataArr["user_phone"]))
        $query = "UPDATE USERS SET user_phone = \"{$dataArr["user_phone"]}\" WHERE user_no = $user_no";
    $result = $mysqli->query($query);
    if ($result) {
        $column = user_select($user_no);
        $json = json_encode(['result' => $result, 'user_arr' => $column]);
    } else {
        $json = json_encode(['result' => $result, 'error' => "{$dataArr["fn"]} : {$mysqli->error}"]);
    }
    echo $json;
}

function amount_insert($dataArr) {
    try {
        global $mysqli;
        $user_no = $dataArr["user_no"];
        $type = $dataArr["type"];
        $val = $dataArr["val"];

        $query = "INSERT INTO `AMOUNT` (user_no, $type) VALUES ($user_no, $val);";
        if ($mysqli->query($query)) {
            $json = json_encode(["result" => true, "user_data" => amount_select($user_no, $type)]);
        }
    } catch (Exception $e) {
        $msg = "Exception {$e->getCode()} : {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}!";
        $json = json_encode(["msg" => $msg]);
    }
    echo $json;
}

function amount_select($user_no, $type) {
    global $mysqli;
    $query = "SELECT SUM($type) AS $type FROM `AMOUNT` WHERE user_no = $user_no;";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row[$type];
}

function amount_list($dataArr) {
    global $mysqli;
    $list = [];
    $user_no = $dataArr["user_no"];
    $type = $dataArr["type"];
    $query = "SELECT * FROM `AMOUNT` WHERE $type != 0 AND user_no = $user_no ORDER BY reg_dt DESC;";
    $result = $mysqli->query($query);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = $row;
    }
    echo json_encode(["result" => $list]);

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
        N_USERS.user_no AS user_no,
        N_USERS.reg_dt AS reg_dt,
        N_USERS.old_dt AS old_dt,
        N_USERS.user_name AS user_name,
        N_USERS.user_phone AS user_phone,
        N_USERS.user_path AS user_path,
        N_USERS.user_ip AS user_ip,
        N_USERS.user_device AS user_device,
        N_USERS.status AS status,
        N_USERS.overlap AS overlap,
        IFNULL(AMOUNT.estimate, 0) AS estimate,
        IFNULL(AMOUNT.payment, 0) AS payment
        FROM
        (SELECT 
        OLD_USERS.user_no AS user_no,
        OLD_USERS.reg_dt AS old_dt,
        REM_USERS.reg_dt AS reg_dt,
        OLD_USERS.user_name AS user_name,
        OLD_USERS.user_phone AS user_phone,
        OLD_USERS.user_path AS user_path,
        OLD_USERS.user_ip AS user_ip,
        OLD_USERS.user_device AS user_device,
        OLD_USERS.status AS status,
        OLD_USERS.overlap AS overlap
        FROM
        (SELECT *, COUNT(T1.user_phone) AS overlap FROM (SELECT *, ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt ASC) as rn FROM `USERS`) AS T1 GROUP BY T1.user_phone) AS OLD_USERS
        LEFT JOIN
        (SELECT T2.reg_dt, T2.user_phone FROM (SELECT *, ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt DESC) as rn FROM `USERS`) AS T2 WHERE T2.rn = 1) AS REM_USERS
        ON OLD_USERS.user_phone = REM_USERS.user_phone ORDER BY reg_dt DESC) AS N_USERS
        LEFT JOIN
        (SELECT user_no, SUM(estimate) AS estimate, SUM(payment) AS payment FROM `AMOUNT` GROUP BY user_no) AS AMOUNT
        ON N_USERS.user_no = AMOUNT.user_no) AS USERS 
        $param_str ORDER BY reg_dt DESC $limit;
    ";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
        "user_no" =>$row["user_no"],
        "reg_dt" =>$row["reg_dt"],
        "old_dt" =>$row["old_dt"],
        "user_name" =>$row["user_name"],
        "user_phone" =>$row["user_phone"],
        "user_path" =>$row["user_path"],
        "user_ip" =>$row["user_ip"],
        "user_device" =>$row["user_device"],
        "status" =>$row["status"],
        "overlap" =>$row["overlap"],
        "estimate" =>$row["estimate"],
        "payment" =>$row["payment"]
        ];
    }
    return $list;
}

function recall_list($userNo) {
    global $mysqli;
    $list = [];
    $sql = "SELECT * FROM `RECALL` WHERE update_no = 0 AND user_no = $userNo ORDER BY reg_dt DESC;";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'user_no'=>$row['user_no']
            ,'reg_dt'=>$row['reg_dt']
            ,'comment'=>$row['comment']
            ,'update_no'=>$row['update_no']
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

function recall_type_list() {
    global $mysqli;
    $list = [];
    $sql ='SELECT * FROM RECALL_TYPE ORDER BY no ASC';
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'recall_type'=>$row['recall_type']
        ];
    }
    return $list;
}
function user_type_list() {
    global $mysqli;
    $list = [];
    $sql ="SELECT * FROM `USER_TYPE` ORDER BY no ASC;";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[] = [
            'no'=>$row['no']
            ,'user_type'=>$row['user_type']
        ];
    }
    return $list;
}

function DB_Exception ($e) {
    // throw new Exception ("A error has occured", 42);
    $msg = "Exception {$e->getCode()} : {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}!";
    $json = json_encode(["msg" => $msg]);
    return $json;
}