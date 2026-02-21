<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content__outer">
        <div class="form">
            <input type="file" name="excel_file" accept=".xls, .xlsx, .csv">
            <button type="button" name="upload_btn" data-form="excel_file">Excel Read</button>
            <button type="button" name="print_btn">인쇄하기</button>
        </div>
        <div id="daily_today"></div>
    </section>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>