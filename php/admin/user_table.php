<?php
include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php';
include $_SERVER["DOCUMENT_ROOT"] . '/php/controller/db_module.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : "";
$search_text = isset($_GET['search_text']) ? $_GET['search_text'] : "";

/* paging : 한 페이지 당 데이터 개수 */
$list_num = 10;

/* paging : 한 블럭 당 페이지 수 */
$page_num = 5;

/* paging : 시작 번호 = (현재 페이지 번호 - 1) * 페이지 당 보여질 데이터 수 */
$start = ($page - 1) * $list_num;

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
$path = $parts['path'];
$new_query = "";
if (isset($parts['query'])) {
    parse_str($parts['query'], $params);
    if (isset($params['page'])) {
        unset($params['page']);
    }
    if (count($params) != 0) {
        $new_query = "&".http_build_query($params);
    }
}

$totalCnt = count(member_list(0, 0, isset($params) ? $params : []));

/* paging : 전체 페이지 수 = 전체 데이터 / 페이지당 데이터 개수, ceil : 올림값, floor : 내림값, round : 반올림 */
$total_page = ceil($totalCnt / $list_num);
// echo "전체 페이지 수 : ".$total_page;

/* paging : 전체 블럭 수 = 전체 페이지 수 / 블럭 당 페이지 수 */
$total_block = ceil($total_page / $page_num);

/* paging : 현재 블럭 번호 = 현재 페이지 번호 / 블럭 당 페이지 수 */
$now_block = ceil($page / $page_num);

/* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
$s_pageNum = ($now_block - 1) * $page_num + 1;
// 데이터가 0개인 경우
if($s_pageNum <= 0){
    $s_pageNum = 1;
};

/* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
$e_pageNum = $now_block * $page_num;
// 마지막 번호가 전체 페이지 수를 넘지 않도록
if($e_pageNum > $total_page){
    $e_pageNum = $total_page;
};
?>
<div id="content__list">
    <section class="content__outer user__statistics__table">
        <table>
            <thead>
                <tr>
                    <th>전체</th>
                    <th>빅크통계</th>
                    <th>빅크) 리콜</th>
                    <th>빅크) 예약완료</th>
                    <th>빅크) 동의/진행</th>
                    <th>빅크) 미진행</th>
                    <th>빅크) 예약취소</th>
                    <th>원내) 소개</th>
                    <th>원내) 인터넷</th>
                    <th>원내) 기타</th>
                </tr>
            </thead>
            <tbody>
                <?php $row = user_statistics(); ?>
                <tr>
                    <td><?php echo number_format($row['total']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_total']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_qutcall']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_completed']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_agree']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_not_agree']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['big_cancel']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['in_introduction']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['in_internet']) ?>&nbsp;명</td>
                    <td><?php echo number_format($row['in_other']) ?>&nbsp;명</td>
                </tr>
                <tr>
                    <td><?php echo number_format($row['total_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_total_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_outcall_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_completed_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_agree_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_not_agree_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['big_cancel_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['in_introduction_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['in_internet_cost']) ?>&nbsp;원</td>
                    <td><?php echo number_format($row['in_other_cost']) ?>&nbsp;원</td>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="content__outer user__table">
        <div class="content__group form">
            <div class="user__search__form">
                <select name="search-type">
                    <option value="0" <?php echo ($search_type == 0) ? "selected" : ""; ?>>전체</option>
                    <option value="1" <?php echo ($search_type == 1) ? "selected" : ""; ?>>전화번호</option>
                    <option value="2" <?php echo ($search_type == 2) ? "selected" : ""; ?>>이름</option>
                </select>
                <input type="text" name="search-text" placeholder="" value="<?php echo $search_text; ?>">
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
                    <th>진행금액</th>
                    <th>견적금액</th>
                    <th>유입경로</th>
                    <th>유입위치</th>
                    <th>리콜상태</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $member_list = member_list($start, $list_num, isset($params) ? $params : []);
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
                        . '<td name="userName">'
                        . '<div class="update">'
                        . '<input data-id="' . $member['no'] . '" type="text" value="' . $member['userName'] . '" disabled>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--update">수정</span>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--update--action">수정하기</span>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--close">취소</span>'
                        . '</div>'
                        . '</td>'
                        . '<td name="userPhone">' . $member['userPhone'] . '</td>'
                        . '<td name="cost">'
                        . '<div class="update">'
                        . '<input data-id="' . $member['no'] . '" type="text" value="' . number_format($member['cost']) . '" disabled>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--update">수정</span>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--update--action">수정하기</span>'
                        . '<span data-id="' . $member['no'] . '" class="btn btn--close">취소</span>'
                        . '</div>'
                        . '</td>'
                        . '<td name=not_decided>' . $member['not_decided'] . '</td>'
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
                    echo '<td colspan="9">';
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
                    <a href="<?php echo $path;?>?page=1<?php echo $new_query; ?>">이전</a>
                <?php } else { ?>
                    <a href="<?php echo $path;?>?page=<?php echo ($page - 1); echo $new_query;?>">이전</a>
                <?php }; ?>

                <?php
                /* pager : 페이지 번호 출력 */
                for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
                ?>
                    <a href="<?php echo $path;?>?page=<?php echo $print_page; echo $new_query;?>"><?php echo $print_page; ?></a>
                <?php }; ?>

                <?php
                /* paging : 다음 페이지 */
                if ($page >= $total_page) {
                ?>
                    <a href="<?php echo $path;?>?page=<?php echo $total_page; echo $new_query;?>">다음</a>
                <?php } else { ?>
                    <a href="<?php echo $path;?>?page=<?php echo ($page + 1); echo $new_query;?>">다음</a>
                <?php }; ?>

            </p>
        </div>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>