<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>엑셀파일읽기</title>
</head>

<body>
    <form name="add_form_entry" id="add_form_entry" method="post" action="excel_file_read.php"
        enctype="multipart/form-data">
        <label for="inputFileName">Select a file:</label>
        <input type="file" name="inputFileName" size="40">
        <input type="submit" value="확인">
    </form>
</body>

</html>