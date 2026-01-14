<?php
include '../header.php';
include 'dbconnect.php';
?>
<section class="table section-padding-type-01">
    <div class="title-type-01 section-padding-type-05">
        <?php
            $sql = 'SELECT 
            SUM(cost) as cost_total, 
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS agree_total, 
            COUNT(*) AS total_count 
            FROM VISIT;';
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="column">
            <h4>2021년 DB마케팅</h4>
        </div>
        <div class="column">
            <h5>구글애드스 디스플레이 광고료 : <?php echo number_format(1899678); ?>원<br>
            합계매출 : <?php echo number_format($row['cost_total']); ?>원<br>
            광고대비효과(백분율) : <span style="color: #ed5464; font-size: 1.5em"><?php echo round(((int)$row['cost_total'] / 1899678) * 100, 2) . '%'?></span>
            </h5>
        </div>
        <div class="column">
            <p>
                총 DB 갯 수 : <?php echo number_format($row['total_count']); ?>명<br>
                총 내원/동의 수 : <?php echo number_format($row['agree_total']); ?>명<br>
                동의/수납(백분율) : <span style="color: #ed5464;"><?php echo round(((int)$row['agree_total'] / (int)$row['total_count']) * 100, 2) . '%'?></span>
            </p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>순번</th>
                <th>상태</th>
                <th>날짜</th>
                <th>상담계획</th>
                <th>이름</th>
                <th>연락처</th>
                <th>리콜상태</th>
                <th>유입경로</th>
                <th>유입위치</th>
                <th>디바이스</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $sql = 'SELECT * FROM  VISIT ORDER BY no DESC;';
    // $sql = 'SELECT  * FROM RECALL WHERE userNo = 1 ORDER  BY recallDate DESC;';
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr id="user-' . $row['no'] .'">';
        echo '<td name="no" data-value="' . $row['no'] . '">' . $row['no'] .'</td>';
        echo '<td style="font-weight:500; color: ' . ($row['status'] == 1 ? '#239600' : '#ed5464') . ';" name="status" data-value="' . $row['status'] . '">' . ($row['status'] == 1 ? '예약완료' : '미예약') .'</td>';
        echo '<td name="visitDate" data-value="' . $row['visitDate'] . '">' .$row['visitDate'] .'</td>';
        echo '<td name="cost" data-value="' . $row['cost'] . '">' . number_format($row['cost']) .'</td>';
        echo '<td name="userName" data-value="' . $row['userName'] . '">' . $row['userName']. '</td>';
        echo '<td name="userPhone" data-value="' . $row['userPhone'] . '">' . $row['userPhone'] . '</td>';
        $recall_sql = 'SELECT  * FROM RECALL WHERE status = 0 AND userNo = ' . $row['no'] . ' ORDER  BY recallDate DESC;';
        $recall_result = mysqli_query($conn, $recall_sql);
        echo '<td class="recall-list">';
        echo '<div class="btn-group">';
        echo '<h6 class="recall-form-open-btn" data-value="' . $row['no'] . '">리콜기록추가</h6>';
        echo '<h6 class="cost-form-open-btn" data-value="' . $row['no'] . '">상담계획추가</h6>';
        echo '</div>';
        echo '<div class="recall-form" style="display: none;">
                <select>
                    <option value="0">예약완료</option>
                    <option value="1">전화부재</option>
                    <option value="2">전화돌림</option>
                    <option value="3">나중에 전화주세요.</option>
                    <option value="4">직접 전화주신데요.</option>
                    <option value="5">문자 보내드렸어요.</option>
                    <option value="6">카카오톡 보내드렸어요.</option>ㅍ
                    <option value="7">기타</option>
                </select>
                <input type="text" placeholder="기타 : 내용을적어주세요." value="">
                <div class="btn">
                    <button class="recall-form-send" data-value="' . $row['no'] . '">저장하기</button>
                </div>
            </div>';
        echo '<div class="cost-form" style="display: none;">
                <input type="text" placeholder="기타 : 계약금액을적어주세요.." value="">
                <div class="btn">
                    <button class="cost-form-send" data-value="' . $row['no'] . '">저장하기</button>
                </div>
            </div>';
        echo '<ul>';
        if (mysqli_num_rows($recall_result) != 0) {
            $recall_list = array();
            while ($recall_row = mysqli_fetch_array($recall_result)) {
                $recall_list[] = array('recallNo' => $recall_row['no'], 'recallDate' => $recall_row['recallDate'], 'comment' => $recall_row['comment']);
            }
            for ($i = 0; $i < count($recall_list); $i++) {
                echo '<li' . ($i > 1 ? ' style="display: none;" class="more"' : '') . '>' . $recall_list[$i]['recallDate'] . '&nbsp;' . $recall_list[$i]['comment'] . '&nbsp;<span name="' . $row['no'] . '" class="recall-delete" data-value="' . $recall_list[$i]['recallNo'] . '">삭제</span></li>';
            }
            if (count($recall_list) > 2) {
                echo '<li class="more-open" data-value="' . $row['no'] . '">더보기</li>';
            }
        } else {
            echo '<li class="empty">리콜내역이 없습니다.</li>';
        }
        echo '</ul>';
        echo '</td>';
        echo '<td class="path">' . ($row['path'] == '' || $row['path'] == null ? '-' : $row['path']) . '</td>';
        echo '<td>' . ($row['ip'] == '' || $row['ip'] == null ? '-' : $row['ip']) . '</td>';
        echo '<td>' . ($row['device'] == '' || $row['device'] == null ? '-' : $row['device']) . '</td>';
        echo '</tr>';
    }
    ?>
        </tbody>
    </table>
</section>
<?php include '../footer.php'; ?>