<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include 'db_connect.php';
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
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr id="' . $row['no'] . '">'
                    . '<td name="no">' . $row['no'] . '</td>'
                    . '<td name="visitDate">' . $row['visitDate'] . '</td>'
                    . '<td name="status">' . $row['status'] . '</td>'
                    . '<td name="userName">' . $row['userName'] . '</td>'
                    . '<td name="userPhone">' . $row['userPhone'] . '</td>'
                    . '<td name="path">' . $row['path'] . '</td>'
                    . '<td name="ip">' . $row['ip'] . '</td>'
                    . '<td class="recall__column">'
                    . '<ul>'
                    . '<li class="form_open" data-id="' . $row['no'] . '">리콜추가</li>'
                    . '<li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>'
                    . '<li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>'
                    . '<li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>'
                    . '</ul>'
                    . '</td>'
                    . '</tr>'
                    . '<tr class="recall__row" data-id="' . $row['no'] . '">'
                    . '<td colspan="8">'
                    . '<div class="recall__form" data-id="' . $row['no'] . '">'
                    . '<select name="status">'
                    . '<option value="0">예약완료</option>'
                    . '<option value="1">전화부재</option>'
                    . '<option value="2">전화돌림</option>'
                    . '<option value="3">나중에 전화주세요.</option>'
                    . '<option value="4">직접 전화주신데요.</option>'
                    . '<option value="5">문자 보내드렸어요.</option>'
                    . '<option value="6">카카오톡 보내드렸어요.</option>ㅍ'
                    . '</select>'
                    . '<input name="comment" type="text" placeholder="기타 : 내용">'
                    . '<button type="button" class="insert" data-id="' . $row['no'] . '">추가하기</button>'
                    . '<button type="button" class="close" data-id="' . $row['no'] . '">닫기</button>'
                    . '</div>'
                    . '</td>'
                    . '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>