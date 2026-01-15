<?php
$mysqli = @new mysqli('yeppeum.kr', 'kskim5958', 'rhkdtjr77', 'kskim5958');
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
$sql = 'SELECT * FROM  VISIT ORDER BY no DESC;';
$result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
# key value 형태
// while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
//     printf ("%s (%s)\n", $row["no"], $row["userName"]);
// }
# 단순 배열형태
// while ($row = $result -> fetch_array(MYSQLI_NUM)) {
//     printf ("%s (%s)\n", $row[0], $row[1]);
// }
// echo "Affected rows: " . $mysqli -> affected_rows;
$result->free_result();
$mysqli->close();