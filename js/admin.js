$(document).ready(function () {
    $(".user__table tbody .user__information:odd").css("background-color", "var(--color-white-1)");
});

$(document).on('keyup', '.user__search__form input[name="userName"], .user__form input[name="userName"]', function() {
    $(this).val($(this).val().replace(/[^ㄱ-ㅣ가-힣]/g, ""));
});

$(document).on('keyup', '.user__form input[name="userPhone"]', function() {
    const number = $(this).val();
    $(this).val(fn_phone_format(number)); 
});

$(document).on('keyup', '.user__information td[name="cost"] input, .user__information td[name="not_decided"] input', function() {
    const number = $(this).val();
    $(this).val(fn_phone_format(number)); 
    $(this).val($(this).val().replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
});

// 유저 진행금액 업데이트(수정버튼 활성화)
$(document).on('click', '.user__information td[name="cost"] .btn--update', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="cost"]');
    const cost = element.find('input').val();
    Glover_cost = cost;
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update--action').toggle();
    element.find('input').prop('disabled', false);
    element.find('input')
    .css('padding', '5px 10px')
    .css('box-sizing', 'border-box')
    .css('background-color', 'var(--color-gray-1)')
    .css('border-radius', '5px');
    element.find('input').focus().val("").val(cost.replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
});

// 유저 진행금액 업데이트(수정하기 버튼 활성화/액션)
$(document).on('click', '.user__information td[name="cost"] .btn--update--action', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="cost"]');
    let cost = element.find('input').val().replace(/,/g, '');
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update').toggle();
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName: 'member_update',
            userNo: userNo,
            cost: cost
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            const new_cost = data.list.cost;
            alert(`[${Glover_cost}원] 에서 [${new_cost.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}원]으로 변경하였습니다!`);
        } else {
            console.log(data.error);
        }
    });
});

// 유저 진행금액 업데이트(수정취소 버튼 활성화)
$(document).on('click', '.user__information td[name="cost"] .btn--close', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="cost"]');
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');
    element.find('input').val(Glover_cost);
    $(this).toggle();
    element.find('.btn--update').toggle();
    element.find('.btn--update--action').toggle();
});

// 유저 진행 예정금액 업데이트(수정버튼 활성화)
$(document).on('click', '.user__information td[name="not_decided"] .btn--update', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="not_decided"]');
    const not_decided = element.find('input').val();
    Glover_not_decided = not_decided;
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update--action').toggle();
    element.find('input').prop('disabled', false);
    element.find('input')
    .css('padding', '5px 10px')
    .css('box-sizing', 'border-box')
    .css('background-color', 'var(--color-gray-1)')
    .css('border-radius', '5px');
    element.find('input').focus().val("").val(not_decided.replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
});

// 유저 진행 예정금액 업데이트(수정하기 버튼 활성화/액션)
$(document).on('click', '.user__information td[name="not_decided"] .btn--update--action', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="not_decided"]');
    let not_decided = element.find('input').val().replace(/,/g, '');
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update').toggle();
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName: 'member_update',
            userNo: userNo,
            not_decided: not_decided
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            const new_not_decided = data.list.not_decided;
            alert(`[${Glover_not_decided}원] 에서 [${new_not_decided.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}원]으로 변경하였습니다!`);
        } else {
            console.log(data.error);
        }
    });
});

// 유저 진행금액 업데이트(수정취소 버튼 활성화)
$(document).on('click', '.user__information td[name="not_decided"] .btn--close', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="not_decided"]');
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');
    element.find('input').val(Glover_cost);
    $(this).toggle();
    element.find('.btn--update').toggle();
    element.find('.btn--update--action').toggle();
});

// 유저 이름 업데이트(수정버튼 활성화)
$(document).on('click', '.user__information td[name="userName"] .btn--update', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="userName"]');
    const userName = element.find('input').val();
    Glover_userName = userName;
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update--action').toggle();
    element.find('input').prop('disabled', false);
    element.find('input')
    .css('padding', '5px 10px')
    .css('box-sizing', 'border-box')
    .css('background-color', 'var(--color-gray-1)')
    .css('border-radius', '5px');
    element.find('input').focus().val("").val(userName);
});

// 유저 이름 업데이트(수정하기 버튼 활성화/액션)
$(document).on('click', '.user__information td[name="userName"] .btn--update--action', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="userName"]');
    const userName = element.find('input').val();
    $(this).toggle();
    element.find('.btn--close').toggle();
    element.find('.btn--update').toggle();
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            functionName: 'member_update',
            userNo: userNo,
            userName: userName
        }
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.result) {
            const new_userName = data.list.userName;
            alert(`[${Glover_userName}] 이름에서 [${new_userName}]로/으로 변경하였습니다!`);
        } else {
            console.log(data.error);
        }
    });
});

// 유저 이름 업데이트(수정취소 버튼 활성화)
$(document).on('click', '.user__information td[name="userName"] .btn--close', function() {
    const userNo = $(this).attr('data-id');
    const element = $('#' + userNo).find('td[name="userName"]');
    element.find('input').prop('disabled', true);
    element.find('input').css('background-color', 'transparent');
    element.find('input').val(Glover_userName);
    $(this).toggle();
    element.find('.btn--update').toggle();
    element.find('.btn--update--action').toggle();
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

$(document).on('change', 'select[name="user_type"]', function() {
    const user_no = $(this).data('user--no');
    const status = $(this).children('option:selected').val();

    // $.ajax({
    //     url: "/php/controller/db_module.php",
    //     type: "post",
    //     data: {
    //         functionName : 'member_update',
    //         userNo : userNo,
    //         status : status
    //     }
    // }).done(function (data) {
    //     data = JSON.parse(data);
    //     if (data.result) {
    //         const userName = data.list.userName;
    //         const status = data.list.status;
    //         const commentType = $('#' + data.list.no).find('[name="member-type"] option[value="' + data.list.status + '"]').text();
    //         alert(`${userName}님의 상태를 [${commentType}]로/으로 변경하였습니다!`);
    //     } else {
    //         console.log(data.error);
    //     }
    // });
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