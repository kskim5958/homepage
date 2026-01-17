<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_module.php';
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
                $member_list = member_list();
                foreach ($member_list as $member) {
                    echo '<tr class="user__information" id="' . $member['no'] . '">'
                    . '<td name="no">' . $member['no'] . '</td>'
                    . '<td name="visitDate">' . $member['visitDate'] . '</td>'
                    . '<td name="status" ' . $member['style'] . '>' . $member['status'] . '</td>'
                    . '<td name="userName">' . $member['userName'] . '</td>'
                    . '<td name="userPhone">' . $member['userPhone'] . '</td>'
                    . '<td name="path">' . $member['path'] . '</td>'
                    . '<td name="ip">' . $member['ip'] . '</td>'
                    . '<td class="recall__column">'
                    . '<ul>';
                    echo '<li class="form_open" data-id="' . $member['no'] . '">리콜추가</li>';
                    $recall_list = recall_list($member['no']);
                    $recallCnt = count($recall_list);
                    if ($recallCnt != 0) {
                        foreach ($recall_list as $index => $recall) {
                            $index > 2 ? $classAttribute = 'class="hide"' : $classAttribute = '';
                            echo '<li ' . $classAttribute . '>'
                            . $recall['recallDate'] . '&nbsp;'
                            . $recall['comment'] . '&nbsp;'
                            .'<span class="del" data-id="' . $recall['no'] . '" data-userid="' . $recall['userNo'] . '">삭제</span>'
                            .'</li>';
                        }
                        if ($recallCnt > 3) echo '<li class="recall_list_open" data-id="' . $member['no'] . '">더보기</li>';
                    }
                    echo '</ul></td></tr>';
                    echo '<tr class="recall__row" data-id="' . $member['no'] . '">';
                    echo '<td colspan="8">';
                    echo '<div class="recall__form" data-id="' . $member['no'] . '">';
                    echo '<select name="comment-type">';
                    $comment_type_list = comment_type_list();
                    foreach ($comment_type_list as $comment_type) {
                        echo '<option value="' . $comment_type['no'] . '">' . $comment_type['comment'] . '</option>';
                    }
                    echo '</select>'
                    . '<input name="comment-text" type="text" placeholder="기타 : 내용">'
                    . '<button type="button" class="insert" data-id="' . $member['no'] . '">추가하기</button>'
                    . '<button type="button" class="close" data-id="' . $member['no'] . '">닫기</button>'
                    . '</div></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>
