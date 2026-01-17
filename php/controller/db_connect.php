<?php
$mysqli = @new mysqli('yeppeum.kr', 'kskim5958', 'rhkdtjr77', 'kskim5958');
if($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}

# mysql query example
# ALTER TABLE COMMENT_TYPE MODIFY COLUMN no INT NOT NULL AUTO_INCREMENT PRIMARY KEY;

// $id = 1; // 업데이트할 레코드 ID
// $new_name = "New Name";

// // 2. UPDATE 쿼리 실행 (Prepared Statement)
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