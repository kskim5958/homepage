$('.user__table .form_open, .recall__form .close').on('click', function() {
    const user_id = $(this).attr('data-id');
    $('.recall__row[data-id="' + user_id + '"]').toggle();
});

$('.recall__form .insert').on('click', function() {
    let user_id = $(this).attr('data-id');
    let element = $('.recall__form[data-id="' + user_id + '"]');
    let status = element.find('select[name="status"] option:selected').val();
    let comment = element.find('input[name="comment"]').val();
    // comment에 값이 있으면 status(7)를 기타로 변경
    if (comment == '') status = 7;
});