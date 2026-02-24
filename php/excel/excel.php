<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content__outer">
        <div class="excel_file">
            <div class="comment">
                <h1>업로드할 파일을 선택하세요.</h1>
                <p>덴트웹의 카드/현금/계좌이체 합계를 확인하세요.</p>
            </div>
            <input type="file" id="file_name" name="excel_file" accept=".xls, .xlsx, .csv">
            <button type="button" name="upload_btn" data-form="excel_file">엑셀 읽어오기</button>
        </div>
        <div id="daily_today"></div>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>