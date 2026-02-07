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
        case "amount_update":
            amount_update($dataArr);
            break;
        case "amount_list":
            amount_list($dataArr);
            break;
        case "recall_insert":
            recall_insert($dataArr);
            break;
        case "recall_list":
            recall_list($dataArr);
            break;
        case "recall_update":
            recall_update($dataArr);
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
    if ($result) {
        $json = json_encode(['result' => $result]);
        echo $json;
    } else {
        mysqli_error_msg($mysqli);
    }
}

// user 단순조회
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
    $btn_name = $dataArr["btn_name"];
    $val = $dataArr["val"];
    $val = ($btn_name == "status") ? $val : "\"$val\"";
    $query = "UPDATE USERS SET $btn_name = $val WHERE user_no = $user_no";
    $result = $mysqli->query($query);
    if ($result) {
        $column = user_select($user_no);
        $json = json_encode(['result' => $result, 'user_arr' => $column]);
        echo $json;
    } else {
        mysqli_error_msg($mysqli);
    }
}

function amount_insert($dataArr) {
    global $mysqli;
    $user_no = $dataArr["user_no"];
    $type = $dataArr["type"];
    $val = $dataArr["val"];
    $query = "INSERT INTO `AMOUNT` (user_no, $type) VALUES ($user_no, $val);";
    $result = $mysqli->query($query);
    if ($result) {
        $json = json_encode(["result" => $result, "amount_sum" => amount_sum($user_no)]);
        echo $json;
    } else {
        mysqli_error_msg($mysqli);
    }
}

function amount_sum($user_no) {
    global $mysqli;
    $query = "SELECT user_no, SUM(estimate) AS estimate, SUM(payment) AS payment FROM `AMOUNT` WHERE update_no = 0 AND user_no = $user_no GROUP BY user_no;";
    $result = $mysqli->query($query);
    $column = $result->fetch_assoc();
    return $column;
}

function amount_list($dataArr, $data_format="json") {
    global $mysqli;
    $list = [];
    $user_no = $dataArr["user_no"];
    $type = $dataArr["type"];
    $query = "SELECT * FROM `AMOUNT` WHERE update_no = 0 AND $type != 0 AND user_no = $user_no ORDER BY reg_dt DESC;";
    $result = $mysqli->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        if ($data_format == "arr") {
            $list = ["result" => true, "list" => $list];
            return $list;
        } else {
            $json = json_encode(["result" => true, "list" => $list]);
            echo $json;
        }
    } else {
        if ($data_format == "arr") {
            $error_msg = ["result" => false, "error" => $mysqli->error];
            return $error_msg;
        } else {
            mysqli_error_msg($mysqli);
        }
    }
}

function amount_update($dataArr) {
    global $mysqli;
    $no = $dataArr["no"];
    $query = "UPDATE `AMOUNT` SET update_no = 1 WHERE no = $no;";
    $result = $mysqli->query($query);

    if ($result) {
        $json = json_encode(amount_list($dataArr, "arr"));
        echo $json;
    } else {
        mysqli_error($mysqli);
    }
}

// users 리스트 조회
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
    $query = "
        SELECT * FROM
        (SELECT
        T1.user_no AS user_no,
        T1.reg_dt AS first_reg_dt,
        T2.reg_dt AS latest_reg_dt,
        T1.user_name AS user_name,
        T1.user_phone AS user_phone,
        IFNULL(T3.estimate, 0) AS estimate,
        IFNULL(T3.payment, 0) AS payment,
        T1.user_path AS user_path,
        T1.user_ip AS user_ip,
        T1.user_device AS user_device,
        T1.status AS status,
        T1.update_no AS update_no,
        T1.dup_cnt AS dup_cnt,
        T4.recall_reg_dt AS recall_reg_dt,
        T4.recall_comment AS recall_comment,
        IFNULL(T4.recall_cnt, 0) AS recall_cnt
        FROM
        (SELECT * FROM
        (SELECT *,
        ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt ASC) AS first_data,
        COUNT(*) OVER (PARTITION BY user_phone) AS dup_cnt
        FROM `USERS`) AS T WHERE T.first_data = 1) AS T1
        LEFT JOIN
        (SELECT T.user_phone AS user_phone, T.reg_dt AS reg_dt FROM
        (SELECT *,
        ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt DESC) AS latest_data
        FROM `USERS`) AS T WHERE T.latest_data = 1) AS T2 ON T1.user_phone = T2.user_phone
        LEFT JOIN
        (SELECT user_no, SUM(estimate) as estimate, SUM(payment) AS payment
        FROM `AMOUNT` WHERE update_no = 0 GROUP BY user_no) AS T3 ON T1.user_no = T3.user_no
        LEFT JOIN
        (SELECT
        T.user_no AS user_no,
        T.reg_dt AS recall_reg_dt,
        T.comment AS recall_comment,
        T.recall_cnt AS recall_cnt
        FROM
        (SELECT *, 
        ROW_NUMBER() OVER(PARTITION BY user_no ORDER BY reg_dt DESC) AS rn,
        COUNT(*) OVER(PARTITION BY user_no) AS recall_cnt
        FROM `RECALL`) AS T WHERE T.rn = 1) AS T4 ON T1.user_no = T4.user_no) AS USERS
        $param_str ORDER BY latest_reg_dt DESC $limit;
    ";
    $result = $mysqli->query($query);
    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }
    return $list;
}

function recall_insert($dataArr) {
    global $mysqli;
    $user_no = $dataArr["user_no"];
    $comment = $dataArr['comment'];
    $query = "INSERT INTO `RECALL` (user_no, comment) VALUES ($user_no, \"$comment\");";
    $result = $mysqli->query($query);

    if ($result) {
        $json = json_encode(["result" => true]);
        echo $json;
    } else {
        mysqli_error_msg($mysqli);
    }
}

function recall_update($dataArr) {
    global $mysqli;
    $user_no = $dataArr["user_no"];
    $comment = $dataArr['comment'];
    $query = "INSERT INTO `RECALL` (user_no, comment) VALUES ($user_no, \"$comment\");";
    $result = $mysqli->query($query);

    if ($result) {
        $json = json_encode(["result" => true]);
        echo $json;
    } else {
        mysqli_error_msg($mysqli);
    }
}

function recall_list ($dataArr) {
    global $mysqli;
    $list = [];
    $user_no = $dataArr["user_no"];
    $query = "SELECT * FROM `RECALL` WHERE update_no = 0 AND user_no = $user_no ORDER BY reg_dt DESC;";
    $result = $mysqli->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        echo json_encode(["result" => true, "list" => $list]);
    } else {
        mysqli_error_msg($mysqli);
    }
}

function recall_type_list() {
    global $mysqli;
    $list = [];
    $query ="SELECT * FROM `RECALL_TYPE` ORDER BY no ASC";
    $result = $mysqli->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
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

function mysqli_error_msg ($mysqli) {
    /** @var mysqli $mysqli */
    $json = json_encode(["result" => false, "error" => $mysqli->error]);
    echo $json;
}