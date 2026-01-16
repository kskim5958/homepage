<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_connect.php';
?>
<div id="content__list">
    <section class="content__outer user__table">
        <table>
            <thead>
                <tr>
                    <th>순번</th>
                    <th>날짜</th>
                    <th>상태</th>
                    <th>이름</th>
                    <th>연락처</th>
                    <th>유입경로</th>
                    <th>유입위치</th>
                    <th>리콜상태</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // no visitDate userName userPhone device ip path status cost
                $sql = 'SELECT * FROM  VISIT ORDER BY no DESC;';
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr id="' . $row['no'] . '">'
                    . '<td name="no">' . $row['no'] . '</td>'
                    . '<td name="visitDate">' . $row['visitDate'] . '</td>'
                    . '<td name="status">' . $row['status'] . '</td>'
                    . '<td name="userName">' . $row['userName'] . '</td>'
                    . '<td name="userPhone">' . $row['userPhone'] . '</td>'
                    . '<td name="path">' . $row['path'] . '</td>'
                    . '<td name="ip">' . $row['ip'] . '</td>'
                    . '<td class="recall__column">'
                    . '<ul>';
                    echo '<li class="form_open" data-id="' . $row['no'] . '">리콜추가</li>';
                    $sql = 'SELECT  * FROM RECALL WHERE userNo = ' . $row['no'] . ' ORDER BY recallDate DESC;';
                    $result_r = $mysqli->query($sql);
                    $count_r = $result_r->num_rows;
                    if ($count_r != 0) {
                        $index = 1;
                        while ($row_r = $result_r->fetch_array(MYSQLI_ASSOC)) {
                            $index > 3 ? $class_r = 'class="hide"' : $class_r = '';
                            echo '<li ' . $class_r . '>'
                            . $row_r['recallDate'] . '&nbsp;'
                            . $row_r['comment'] . '&nbsp;'
                            .'<span class="del" data-id="' . $row_r['no'] . '" data-userid="' . $row_r['userNo'] . '">삭제</span>'
                            .'</li>';
                            $index++;
                        }
                        if ($count_r > 3) echo '<li class="recall_list_open" data-id="' . $row['no'] . '">더보기</li>';
                    }
                    echo '</ul></td></tr>';
                    echo '<tr class="recall__row" data-id="' . $row['no'] . '">';
                    echo '<td colspan="8">';
                    echo '<div class="recall__form" data-id="' . $row['no'] . '">';
                    echo '<select name="status">';
                    $sql ='SELECT * FROM RECALL_STATUS ORDER BY no ASC';
                    $result_r_s = $mysqli->query($sql);
                    while ($row_r_s = $result_r_s->fetch_array(MYSQLI_ASSOC)) {
                        echo '<option value="' . $row_r_s['no'] . '">' . $row_r_s['comment'] . '</option>';
                    }
                    echo '</select>'
                    . '<input name="comment" type="text" placeholder="기타 : 내용">'
                    . '<button type="button" class="insert" data-id="' . $row['no'] . '">추가하기</button>'
                    . '<button type="button" class="close" data-id="' . $row['no'] . '">닫기</button>'
                    . '</div></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>