<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content user__table">
        <table>
            <thead>
                <tr>
                    <th>순번</th>
                    <th>상태</th>
                    <th>이름</th>
                    <th>연락처</th>
                    <th>유입경로</th>
                    <th>유입위치</th>
                    <th>리콜상태</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>순번</td>
                    <td>상태</td>
                    <td>이름</td>
                    <td>연락처</td>
                    <td>유입경로</td>
                    <td>유입위치</td>
                    <td>
                        <ul class="text__group">
                            <li class="text--small text--orange">리콜추가</li>
                            <li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>
                            <li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>
                            <li>2026-01-08 12:56 카카오톡 발송&nbsp;<span class="text--small text--orange">삭제</span></li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="insert__form">
                        <select name="" id="">
                            <option value="">option type 01</option>
                            <option value="">option type 01</option>
                            <option value="">option type 01</option>
                            <option value="">option type 01</option>
                            <option value="">option type 01</option>
                        </select>
                        <input type="text">
                        <button type="button">추가하기</button>
                        <button type="button">닫기</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>