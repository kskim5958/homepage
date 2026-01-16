<?php
include 'dbconnect.php';
include '../controller/controller.php';

if ($_POST['functionName'] == 'user_recall_insert') {
    user_recall_insert();
}
if ($_POST['functionName'] == 'user_call_insert') {
    user_call_insert();
}

// user user call insert,
function user_call_insert()
{
    $device = device_information();
    $ip = ip_information($_SERVER['REMOTE_ADDR']);
    $referer = referer_information($_POST['referer']);
    if ($ip['result']) {
        $ip = $ip['city'] . '/' . $ip['ip'] . '(' . $ip['latitude'] .  ',' . $ip['longitude'] .')';
    } else {
        $ip = $ip['ip'];
    }
    $sql = 'INSERT INTO VISIT (userName, userPhone, device, ip, path) VALUES ("' . $_POST['name'] . '", "' . $_POST['phone'] . '", "' . $device . '", "' . $ip . '" ,"' . $referer . '");';
    global $conn;
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    echo json_encode(array('result' => true));
}

// user user recall insert,
function user_recall_insert()
{
    $sql = 'INSERT INTO RECALL VALUES (NULL, ' . $_POST['no'] . ', CURRENT_TIMESTAMP, 0, "' . $_POST['comment'] . '");';
    global $conn;
    if (mysqli_query($conn, $sql)) {
        $sql = 'SELECT * FROM RECALL WHERE no =' . mysqli_insert_id($conn) . ';';
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        $json = json_encode(array('recallNo' => $row['no'], 'recallDate' => $row['recallDate'], 'comment' => $row['comment']));
        echo ($json);
    }
}

// user user visit insert
function user_visit_insert()
{
    $sql = '';
    global $conn;
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
