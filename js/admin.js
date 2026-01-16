$(document).on('click', '.user__table .form_open, .recall__form .close', function() {
    const user_id = $(this).attr('data-id');
    $('.recall__row[data-id="' + user_id + '"]').toggle();
});

$(document).on('click', '.recall__column .recall_list_open', function() {
    $(this).parent().children('.hide').toggle();
});

$(document).on('click', '.recall__form .insert', function() {
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
        if (data.result) {
            let listCnt = data.list.length;
            let html = '<li class="form_open" data-id="' + userNo + '">리콜추가</li>';
            data.list.forEach((list, index) => {
                let classAttribute = index > 2 ? 'class="hide"' : '';
                html += '<li ' + classAttribute + '>'
                + list.recallDate + '&nbsp;&nbsp;'
                + '<span class="del" data-id="' + list.no + '" data-userid="' + list.userNo + '">삭제</span>'
                + '</li>';
            });
            if (listCnt > 3) html += '<li class="recall_list_open" data-id="' + userNo + '">더보기</li>';
            $('#' + userNo).find('.recall__column ul').empty();
            $('#' + userNo).find('.recall__column ul').append(html);
        } else {
        }
        
    });
});