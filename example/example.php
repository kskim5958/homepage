<?php
// $str = "?page=1&userName=kim&userPhone=010";

$str = "";
if (count($_GET) == 0) {
    $str .= "?page=1";
} elseif (count($_GET) == 1 && array_key_exists("page", $_GET)) {
    $str .= "?page={$_GET["page"]}";
} else {
    foreach ($_GET as $key => $value) {
        $str .= "&$key=$value";
    }
    $str = substr_replace($str, "?", 0, 1);
}
$str = str_replace("?", "", $str);
parse_str($str, $param);
$cnt = count($param);
$index = 1;
$search = "";
foreach ($param as $key => $value) {
    if ($key == 'page') {
        $start = $value;
    } else {
        $search .= "$key = $value";
        $search .= ($cnt > 1 && $cnt != $index) ? " AND " : "";
    }
    $index++;
}
$sql = "SELECT * FROM VISIT $search LIMIT $start, 10";
echo $sql;

// function fn_example($arr=[]) {
//     $cnt = count($arr);
//     $str = '';
//     if ($cnt != 0) {
//         $index = 1;
//         foreach ($arr as $key => $value) {
//             $str .= " $key = $value ";
//             $str .= ($cnt > 1 && $cnt != $index) ? "AND" : "";
//             $index++;
//         }
//     }
//     return $str;
// }
// $arr = ['no'=>1000, 'userName'=>'kim', 'comment'=>'content comment'];
// echo fn_example($arr);

# mysqli 예제
// $mysqli = new mysqli('yeppeum.kr', 'kskim5958', 'rhkdtjr77', 'kskim5958');
// if($mysqli->connect_errno) {
//     echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
//     exit();
// }
// $sql = 'SELECT * FROM  VISIT ORDER BY no DESC;';
// $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

// echo "Affected rows: " . $mysqli -> affected_rows;


// $mysqli->close();

// # key value 형태
// while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
//     printf ("%s (%s)\n", $row["no"], $row["userName"]);
// }
// $result->free_result();
// # 단순 배열형태
// while ($row = $result -> fetch_array(MYSQLI_NUM)) {
//     printf ("%s (%s)\n", $row[0], $row[1]);
// }
# ALTER TABLE COMMENT_TYPE MODIFY COLUMN no INT NOT NULL AUTO_INCREMENT PRIMARY KEY;

// $id = 1; // 업데이트할 레코드 ID
// $new_name = "New Name";

// // 2. UPDATE 쿼리 실행 (Prepared Statement)
// // si는 s는 문자열 i는 정수
// $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
// $stmt->bind_param("si", $new_name, $id);
// $stmt->execute();

// // 3. 업데이트 성공 확인 (선택 사항)
// if ($stmt->affected_rows > 0) {
//     // 4. 업데이트된 데이터 가져오기
//     $select_stmt = $conn->prepare("SELECT name, updated_at FROM users WHERE id = ?");
//     $select_stmt->bind_param("i", $id);
//     $select_stmt->execute();
//     $result = $select_stmt->get_result();
//     $row = $result->fetch_assoc();
    
//     echo "업데이트 성공! 변경된 이름: " . $row['name'];
//     $select_stmt->close();
// }

// $stmt->close();
// $conn->close();

# 글로벌변수 힌트
// /** @var mysqli $mysqli */