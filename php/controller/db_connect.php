<?php
$mysqli = @new mysqli('yeppeum.kr', 'kskim5958', 'rhkdtjr77', 'kskim5958');
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
$sql = 'SELECT * FROM  VISIT ORDER BY no DESC;';
$result = $mysqli->query($sql, MYSQLI_STORE_RESULT);