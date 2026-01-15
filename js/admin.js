$('.user__table .form_open, .recall__form .close').on('click', function() {
    const user_id = $(this).attr('data-id');
    $('.recall__row[data-id="' + user_id + '"]').toggle();
});

$('.recall__column .recall_list_open').on('click', function() {
    $(this).parent().children('.hide').toggle();
});

$('.recall__form .insert').on('click', function() {
    let userNo = $(this).attr('data-id');
    let element = $('.recall__form[data-id="' + userNo + '"]');
    let status = element.find('select[name="status"] option:selected').val();
    let comment = element.find('input[name="comment"]').val();
    if (comment != '') status = 999;
    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName : 'recall_insert',
            userNo : userNo,
            status : status,
            comment : comment
        }
    }).done(function (data) {
        data = JSON.parse(data);
        console.log(data.userNo);
    });
});