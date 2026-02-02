<?php
$mysqli = new mysqli('yeppeum.kr', 'kskim5958', 'rhkdtjr77', 'kskim5958');
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
$mysqli->set_charset("utf8mb4");