<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_module.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_paging.php';
?>
<div id="content__list">
    <section class="content__outer user__table">
        <div class="content__group form">
            <div class="user__search__form">
                <input type="text" name="userName" placeholder="성명(한글만)">
                <button type="button" class="search">찾기</button>
            </div>
            <div class="user__form">
                <input type="text" name="userName" placeholder="성명(한글만)">
                <input type="text" name="userPhone" placeholder="연락처(-없이 숫자만)">
                <button type="button" class="insert">추가하기</button>
            </div>
        </div>
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
                $userName = isset($_GET['userName']) ? $_GET['userName'] : "";
                $member_list = member_list($start, $list_num, $userName);
                $member_type_list = member_type_list();
                foreach ($member_list as $member) {
                    echo '<tr class="user__information" id="' . $member['no'] . '">'
                        . '<td name="no">' . $member['no'] . '</td>'
                        . '<td name="visitDate">' . $member['visitDate'] . '</td>'
                        . '<td name="status">'
                        . '<select name="member-type" data-id="' . $member['no'] . '">';
                    foreach ($member_type_list as $member_type) {
                        $selected = ($member['status'] == $member_type['no']) ? 'selected' : '';
                        echo "<option $selected value={$member_type["no"]}>{$member_type["comment"]}</option>";
                    }
                    echo '</select>'
                        . '</td>'
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
                                . '<span class="del" data-id="' . $recall['no'] . '" data-userid="' . $recall['userNo'] . '">삭제</span>'
                                . '</li>';
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
        <div id="pager">
            <p>
                <?php
                /* paging : 이전 페이지 */
                if ($page <= 1) {
                ?>
                    <a href="<?php echo $pagin_url ?>?page=1">이전</a>
                <?php } else { ?>
                    <a href="<?php echo $pagin_url ?>?page=<?php echo ($page - 1); ?>">이전</a>
                <?php }; ?>

                <?php
                /* pager : 페이지 번호 출력 */
                for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
                ?>
                    <a href="<?php echo $pagin_url ?>?page=<?php echo $print_page; ?>"><?php echo $print_page; ?></a>
                <?php }; ?>

                <?php
                /* paging : 다음 페이지 */
                if ($page >= $total_page) {
                ?>
                    <a href="<?php echo $pagin_url ?>?page=<?php echo $total_page; ?>">다음</a>
                <?php } else { ?>
                    <a href="<?php echo $pagin_url ?>?page=<?php echo ($page + 1); ?>">다음</a>
                <?php }; ?>

            </p>
        </div>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>