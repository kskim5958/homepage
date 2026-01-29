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

$totalCnt = count(users(0, 0, isset($params) ? $params : []));

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
    <section class="content__outer user__table">
        <div class="content__group form">
            <div class="user__search__form">
                <select name="search_type">
                    <option value="all" <?php echo ($search_type == "all") ? "selected" : ""; ?>>전체</option>
                    <option value="user_phone" <?php echo ($search_type == "user_phone") ? "selected" : ""; ?>>전화번호</option>
                    <option value="user_name" <?php echo ($search_type == "user_name") ? "selected" : ""; ?>>이름</option>
                </select>
                <input type="text" 
                    name="search_text" 
                    placeholder="검색할 문자입력" 
                    value="<?php echo $search_text; ?>" 
                    <?php echo ($search_type == "all" || $search_type == "") ? "disabled" : ""; ?>
                >
                <button type="button" name="search_btn" class="search">찾기</button>
            </div>
            <div class="user__form">
                <input type="text" name="user_name" placeholder="성명(한글만)">
                <input type="text" name="user_phone" placeholder="연락처(-없이 숫자만)">
                <button type="button" name="insert_btn" class="insert">추가하기</button>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>순번</th>
                    <th>최근날짜</th>
                    <th>최초날짜</th>
                    <th>상태</th>
                    <th>이름</th>
                    <th>연락처</th>
                    <th>진행금액</th>
                    <th>견적금액</th>
                    <th>리콜상태</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = users($start, $list_num, isset($params) ? $params : []);
                $user_type_list = user_type_list();
                foreach ($users as $user) {
                    echo "<tr class=\"user__information\" id=\"{$user["user_no"]}\">"
                        . "<td name=\"user_no\">{$user["user_no"]}</td>"
                        . "<td name=\"reg_dt\">{$user["reg_dt"]}</td>"
                        . "<td name=\"old_dt\">{$user["old_dt"]}</td>"
                        . '<td name="status">'
                        . "<select name=\"user_type\" data-user--no=\"{$user["user_no"]}\">";
                        foreach ($user_type_list as $user_type) {
                            $selected = ($user['status'] == $user_type['no']) ? 'selected' : '';
                            echo "<option $selected value=\"{$user_type["no"]}\">{$user_type["user_type"]}</option>";
                        }
                    echo "</select>"
                        . "</td>"
                        . "<td name=\"user_name\">"
                        . "<div class=\"update\">"
                        . "<input data-user--no=\"{$user["user_no"]}\" type=\"text\" value=\"{$user["user_name"]}\" disabled>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_name\" class=\"btn update\">수정</span>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_name\" class=\"btn action\">수정하기</span>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_name\" class=\"btn close\">취소</span>"
                        . "</div>"
                        . "</td>"
                        . "<td name=\"user_phone\">"
                        . "<div class=\"update\">"
                        . "<input data-user--no=\"{$user["user_no"]}\" type=\"text\" value=\"{$user["user_phone"]}\" disabled>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_phone\" class=\"btn update\">수정</span>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_phone\" class=\"btn action\">수정하기</span>"
                        . "<span data-user--no=\"{$user["user_no"]}\" data-btn--name=\"user_phone\" class=\"btn close\">취소</span>"
                        . "</div>"
                        . "</td>"
                        . "<td name=\"estimate\">"
                        . "<div class=\"btn\">"
                        . "<span name=\"form\">추가</span>"
                        . "<span name=\"list\">목록보기</span>"
                        . "</div>"
                        . "<div name=\"sum\">{$user["estimate"]}</div>"
                        . "<ul class=\"list\">"
                        . "</ul>"
                        . "</td>"
                        . "<td name=\"payment\">"
                        . "<ul class=\"list\">"
                        . "<li>추가하기</li>"
                        . "<li>{$user["payment"]}</li>"
                        . "</ul>"
                        . "</td>"
                        . "<td class=\"recall__column\">"
                        . "<ul>";
                    echo "<li class=\"form_open\" data-user--no=\"{$user["user_no"]}\">리콜추가</li>";
                    $recall_list = recall_list($user["user_no"]);
                    $recallCnt = count($recall_list);
                    if ($recallCnt != 0) {
                        foreach ($recall_list as $index => $recall) {
                            $index > 2 ? $classAttribute = "class=\"hide\"" : $classAttribute = "";
                            echo "<li $classAttribute>"
                                . "{$recall["reg_dt"]}&nbsp;"
                                . "{$recall["comment"]}&nbsp;"
                                . "<span class=\"del\" data-recall--no=\"{$recall["no"]}\" data-user--no=\"{$recall["userNo"]}\">삭제</span>"
                                . "</li>";
                        }
                        if ($recallCnt > 3) echo "<li class=\"recall__list__open\" data-user--no=\"{$user["user_no"]}\">더보기</li>";
                    }
                    echo "</ul></td></tr>";
                    echo "<tr class=\"recall__row\" data-user--no=\"{$user["user_no"]}\">";
                    echo "<td colspan=\"10\">";
                    echo "<div class=\"recall__form\" data-user--no=\"{$user["user_no"]}\">";
                    echo "<select name=\"recall_type\">";
                    $recall_type_list = recall_type_list();
                    foreach ($recall_type_list as $recall_type) {
                        echo "<option value=\"{$recall_type["no"]}\">{$recall_type["recall_type"]}</option>";
                    }
                    echo "</select>"
                        . "<input name=\"comment_text\" type=\"text\" placeholder=\"기타 : 내용\">"
                        . "<button type=\"button\" class=\"insert\" data-user--no=\"{$user["user_no"]}\">추가하기</button>"
                        . "<button type=\"button\" class=\"close\" data-user--no=\"{$user["user_no"]}\">닫기</button>"
                        . "</div></td></tr>";
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