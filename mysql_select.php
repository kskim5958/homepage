<?php include 'dbconnect.php' ?>
<?php 
if ($_POST['functionName'] == 'member_check') {
    member_check();
}
if ($_POST['functionName'] == 'member_logout') {
    member_logout();
}

function member_check () {
    $sql = 'SELECT * FROM MEMBER WHERE id = "' . $_POST['id'] . '" AND pw = "' . $_POST['pw'] . '";';
    global $conn;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $cnt = mysqli_num_rows($result);
    if ($row != null || $cnt != 0) {
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['authority'] = $row['authority'];
        $json = json_encode(array('result' => true, 'id' => $row['id'], 'authority' => $row['authority']));
        echo($json);
    } else {
        $json = json_encode(array('result' => false));
        echo($json);
    }
}
function member_logout () {
    session_start();
    session_unset();
    session_destroy();
    $json = json_encode(array('result' => true));
    echo ($json);
}
?>