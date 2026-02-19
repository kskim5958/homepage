$('[name="upload_btn"]').click(function (e) { 
    e.preventDefault();
    const form = $(this).data("form");
    const file = $(".form").find(`[name="${form}"]`);
    const file_data = file.prop('files')[0];
    const form_data = new FormData();
    form_data.append('file', file_data);

    $.ajax({
        url: "/php/excel/upload.php", // 서버측 PHP 파일
        type: "POST",
        data: form_data,
        contentType: false, // 필수
        processData: false, // 필수
        success: function (data) {
        $("#result_area").html(data); // 새로고침 없이 내용 갱신
        },
        error: function () {
        alert("파일 읽기 실패");
        },
    });
});