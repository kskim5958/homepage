$(document).on('keyup', '.user__search__form input[name="userName"], .user__form input[name="userName"]', function() {
    $(this).val($(this).val().replace(/[^ㄱ-ㅣ가-힣]/g, ""));
});

$(document).on('keyup', '.user__form input[name="userPhone"]', function() {
    const number = $(this).val();
    $(this).val(fn_phone_format(number)); 
});

$(document).on('click', '.user__information td[name="userName"] .btn--update', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="userName"]');
    element.find('.btn--close').toggle();
    element.find('input').prop('disabled', false);
    element.find('input').focus();
    element.find('input')
    .css('padding', '5px 10px')
    .css('box-sizing', 'border-box')
    .css('background-color', 'var(--color-gray-1)')
    .css('border-radius', '5px');
});

$(document).on('click', '.user__information td[name="userName"] .btn--close', function() {
    $(this).toggle();
});

$(document).on('keyup', '.user__search__form input[name="search-text"]', function() {
    const element = $(this).parent().find('select[name="search-type"] option:selected');
    if (element.val() == 1) {
        const number = $(this).val();
        $(this).val(fn_phone_format(number)); 
    }
});

$(document).on('click', '.user__search__form button.search', function() {
    const search_type = $(this).parent().find('select[name="search-type"] option:selected').val();
    const search_text = $(this).parent().find('input[name="search-text"]').val();

    if (search_type == 1) {
        window.location.href = 
        window.location.pathname + "?page=1&userPhone=" + search_text + "&search_type=" + search_type + "&search_text=" + search_text;
    } else if(search_type == 2) {
        window.location.href = 
        window.location.pathname + "?page=1&userName=" + search_text + "&search_type=" + search_type + "&search_text=" + search_text;
    } else {
        window.location.href = window.location.pathname;
    }
});

$(document).on('click', '.user__form button.insert', function() {
    const userName = $(this).parent().children('[name="userName"]').val();
    const userPhone = $(this).parent().children('[name="userPhone"]').val();
    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName : 'user_insert',
            userName : userName,
            userPhone : userPhone
        }
    }).done(function (data) {
        data = JSON.parse(data);
        window.location.href = data.url;
    });
});

$(document).on('change', '.user__information [name="member-type"]', function() {
    const userNo = $(this).attr('data-id');
    const status = $(this).children('option:selected').val();

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName : 'member_update',
            userNo : userNo,
            status : status
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            const userName = data.list.userName;
            const status = data.list.status;
            const commentType = $('#' + data.list.no).find('[name="member-type"] option[value="' + data.list.status + '"]').text();
            alert(`${userName}님의 상태를 [${commentType}]로/으로 변경하였습니다!`);
        } else {
            console.log(data.error);
        }
    });
});

$(document).on('click', '.user__table .form_open, .recall__form .close', function() {
    const user_id = $(this).attr('data-id');
    $('.recall__row[data-id="' + user_id + '"]').toggle();
});

$(document).on('click', '.recall__column .recall_list_open', function() {
    $(this).parent().children('.hide').toggle();
});

$(document).on('click', '.recall__form .insert', function() {
    const userNo = $(this).attr('data-id');
    const element = $('.recall__form[data-id="' + userNo + '"]');
    const comment_type = element.find('select[name="comment-type"] option:selected').text();
    const comment_text = element.find('input[name="comment-text"]').val();
    const comment = comment_text == '' ? comment_type : comment_text;
    
    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName : 'recall_insert',
            userNo : userNo,
            comment : comment
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            let html = '<li class="form_open" data-id="' + userNo + '">리콜추가</li>';
            html += fn_html(userNo, data.list);
            $('#' + userNo).find('.recall__column ul').empty();
            $('#' + userNo).find('.recall__column ul').append(html);
        } else {
            console.log(data.error);
        }
    });
});

$(document).on('click', '.recall__column .del', function() {
    let recallNo = $(this).attr('data-id');
    let userNo = $(this).attr('data-userid');
    
    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName : 'recall_update',
            userNo : userNo,
            recallNo : recallNo
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            let html = '<li class="form_open" data-id="' + userNo + '">리콜추가</li>';
            html += fn_html(userNo, data.list);
            $('#' + userNo).find('.recall__column ul').empty();
            $('#' + userNo).find('.recall__column ul').append(html);
        } else {
            console.log(data.error);
        }
    });
});

const fn_html = (userNo, data)=>{
    let html = '';
    let dataCnt = data.length;
    data.forEach((list, index) => {
        const classAttribute = index > 2 ? 'class="hide"' : '';
        html += '<li ' + classAttribute + '>'
        + list.recallDate + '&nbsp;'
        + list.comment + '&nbsp;'
        + '<span class="del" data-id="' + list.no + '" data-userid="' + list.userNo + '">삭제</span>'
        + '</li>';
    });
    if (dataCnt > 3) html += '<li class="recall_list_open" data-id="' + userNo + '">더보기</li>';
    return html;
}

const fn_phone_format = (str)=>{
    str = str.replace(/[^0-9]/g, "");
    str = str.replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,"$1-$2-$3");
    str = str.replace("--", "-");
    return str;
}