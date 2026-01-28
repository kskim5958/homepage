<?php
$url = $_SERVER["REQUEST_URI"]."?filter=active";
$param_to_remove = "filter"; // 삭제할 파라미터

// 1. URL을 구조별로 분해
$parts = parse_url($url);
// $parts = [ 'scheme' => 'https', 'host' => 'example.com', 'path' => '/page.php', 'query' => 'id=123&sort=asc&filter=active' ];

// 2. 쿼리 문자열을 배열로 변환
if (isset($parts['query'])) {
    parse_str($parts['query'], $params);
    if (isset($params[$param_to_remove])) {
        unset($params[$param_to_remove]);
    }
    $new_query = http_build_query($params);
    $new_url = $parts['path'] . ($new_query ? '?' . $new_query : '');
} else {
    $new_url = $url;
}

echo $new_url;

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