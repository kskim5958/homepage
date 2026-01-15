<?php
$host = 'yeppeum.kr';
// $host = 'localhost';
$username = 'kskim5958';
$password = 'rhkdtjr77';
$database = 'kskim5958';
$conn = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo '서버와 연결실패 : ' . mysqli_connect_error();
}

function userSelect() {
    return;
}