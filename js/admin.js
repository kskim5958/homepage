$(document).ready(function () {
    $(".user__information:odd").css("background-color", "var(--color-white-1)");
    $(".user__information input").each(function(index, item) {
        let input_val = $(this).val();
        let len = (input_val.length > 9) ? 9 : input_val.length;
        $(this).css("width", len + "em");
    });
});

const sch_el = $('.user__search__form');
const user_el = $('.user__information');

const fn_kor_format = (char) => {
    char = char.replace(/[^ㄱ-ㅣ가-힣]/g, "");
    return char;
}

const fn_phone_format = (char) => {
    char = char.replace(/[^0-9]/g, "");
    char = char.replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,"$1-$2-$3");
    char = char.replace("--", "-");
    return char;
}

const fn_update_input_css = (status, element)  =>{
    if (status == "active") {
        element.prop('disabled', false);
        element.css('padding', '5px 10px')
        .css('box-sizing', 'content-box')
        .css('background-color', 'var(--color-gray-1)')
        .css('border-radius', '5px');
    } else {
        element.prop('disabled', true);
        element.css('padding', '0')
        .css('box-sizing', 'unset')
        .css('background-color', 'transparent')
        .css('border-radius', 'unset');
    }
}

// user search form 셀렉트 액션
sch_el.find('select[name="search_type"]').change(function () {
    const element = sch_el.find('input[name="search_text"]');
    const selected = $(this).val();
    (selected == "all") ? element.prop('disabled', true) : element.prop('disabled', false);
});

// user search form 키업 액션
sch_el.find('input[name="search_text"]').keyup(function () {
    let char = $(this).val();
    const selected = sch_el.find('[name="search_type"]').val();
    if (selected == 'user_phone') char = fn_phone_format(char);
    if (selected == 'user_name') char = fn_kor_format(char);
    $(this).val(char);
});

// user search form 버튼 액션
sch_el.find('button[name="search_btn"]').click(function () {
    const sch_type = sch_el.find('[name="search_type"]').val();
    const sch_text = sch_el.find('[name="search_text"]').val();
});

// user 상태 업데이트
user_el.find('select[name="user_type"]').change(function (e) { 
    const user_no = $(this).data('user--no');
    const status = $(this).val();
    const dataArr ={fn: 'user_update', user_no: user_no, status: status};

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            dataArr: dataArr
        }
    }).done(function (data) {
        data = JSON.parse(data);
        const result = data.result;
        const user_data = data.user_data;
        if (result) {
            alert(`${user_data.user_name}님의 상태를 [${user_data.user_comment}]로/으로 변경하였습니다!`);
        } else {
            alert(`${user_data.msg}`);
        }
    });
});

// 유저 이름, 휴대폰번호, 견적금액, 납부금액 업데이트
user_el.find('.btn').click(function (event) {
    const target = $(event.target);
    const user_no = target.data("user--no");;
    const btn_name = target.data("btn--name");
    const element = $(`#${user_no} [name="${btn_name}"]`);
    const input_val = element.find("input").val();
    let dataArr ={user_no: user_no};
    element.find(".btn").toggle();
    if (target.hasClass("update")) fn_update_input_css("active", element.find("input"));
    if (target.hasClass("action") || target.hasClass("close")) fn_update_input_css("inactive", element.find("input"));
    if (target.hasClass("action")) {
        if (btn_name.includes("name")) {
            dataArr.user_name = input_val;
            dataArr.fn = "user_update";
        }
        if (btn_name.includes("phone")) {
            dataArr.user_phone = input_val;
            dataArr.fn = "user_update";
        }
        if (btn_name.includes("estimate")) {
            dataArr.estimate = input_val;
            dataArr.fn = "amount_update";
        }
        if (btn_name.includes("payment")) {
            dataArr.payment = input_val;
            dataArr.fn = "amount_update";
        }
    }
    
    // if (target.hasClass("action")) {
    //     $.ajax({
    //         url: "/php/controller/db_module.php",
    //         type: "post",
    //         data: {
    //         functionName: "member_update",
    //         userNo: userNo,
    //         userName: userName,
    //     },
    //     }).done(function (data) {
    //         data = JSON.parse(data);
    //         if (data.result) {
    //             const new_userName = data.list.userName;
    //             alert(`[${Glover_userName}] 이름에서 [${new_userName}]로/으로 변경하였습니다!`);
    //         } else {
    //             console.log(data.error);
    //         }
    //     });
    // }
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