<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<section class="content__outer">
    <div class="form">
        <input type="file" name="excel_file" accept=".xls, .xlsx, .csv">
        <button type="button" name="upload_btn" data-form="excel_file">Excel Read</button>
    </div>
</section>
<section class="content__outer">
    <div id="result_area"></div>
</section>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>