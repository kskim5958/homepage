const sch_el = $('.user__search__form');
const user_fm_el = $('.user__form');
const user_el = $('.user__information');

var GLOBAL_ADMIN_INPUT_TEXT = "";

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

const fn_thousand_format = (char) => {
    char = char.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return char;
}

const fn_only_num = (char) => {
    char = char.replace(/[^0-9-]/g, '');
    
    // 음수 기호 처리 (맨 앞만 허용)
    let isNegative = false;
    if (char.charAt(0) === '-') {
        isNegative = true;
        char = char.substring(1);
    }
    
    // 음수 기호 복원 및 결과 반영
    char = (isNegative ? '-' : '') + char;
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

const fn_amount_list_html = (btn_type, result)  =>{
    let html = `<ul class="amount__list">`;
    result.forEach((list, index) => {
        html += `<li>
            <span class="item">${list.reg_dt} [${fn_thousand_format(list[btn_type])}원]</span>
            <span class="btn" name="del" data-amount--no="${list.no}">삭제</span>
            </li>`;
    });
    html += "</ul>";
    return html;
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
    const path = `${$(location).prop('pathname')}?`;
    let params = {page: 1}
    let queryString = "";
    if (sch_type == "all") {
        queryString = $.param(params);
    } else {
        params[sch_type] = sch_text;
        params['search_type'] = sch_type;
        params['search_text'] = sch_text;
        queryString = $.param(params);
    }
    const url = path + queryString;
        window.location.href = url;
});

// user insert form 키업 액션
user_fm_el.find('input').keyup(function () {
    let char = $(this).val();
    const type = $(this).attr('name');
    if (type.includes('name')) char = fn_kor_format(char);
    if (type.includes('phone')) char = fn_phone_format(char);
    $(this).val(char);
});

// new user insert 버튼 액션
user_fm_el.find('button[name="insert_btn"]').click(function () {
    const user_name = user_fm_el.find('input[name="user_name"]').val();
    const user_phone = user_fm_el.find('input[name="user_phone"]').val();
    const dataArr = {fn: 'new_user_insert', user_name: user_name, user_phone: user_phone};
    const path = `${$(location).prop('pathname')}`;
    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            dataArr: dataArr
        }
    }).done(function (data) {
        data = JSON.parse(data);
        const result = data.result;
        if (result) {
            alert(`${user_name}님, ${user_phone} 연락처로 등록하였습니다!`);
        } else {
            alert('등록에 실패하였습니다!');
        }
    });
    window.location.href = path;
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

// 유저 이름, 휴대폰번호 업데이트
user_el.find('[name="user_name"] .btn, [name="user_phone"] .btn').click(function (event) {
    const target = $(event.target);
    const user_no = target.data("user--no");;
    const btn_name = target.data("btn--name");
    const element = $(`#${user_no} [name="${btn_name}"]`);
    const input_val = element.find("input").val();
    let dataArr ={user_no: user_no};
    element.find(".btn").toggle();
    if (target.hasClass("update")) {
        GLOBAL_ADMIN_INPUT_TEXT = input_val;
        fn_update_input_css("active", element.find("input"));
    }
    if (target.hasClass("close")) {
        fn_update_input_css("inactive", element.find("input"));
        element.find("input").val(GLOBAL_ADMIN_INPUT_TEXT);
    }
    if (target.hasClass("action")) {
        fn_update_input_css("inactive", element.find("input"));
        if (btn_name == "user_name") {
            dataArr.user_name = input_val;
            dataArr.fn = "user_update";
        }
        if (btn_name == "user_phone") {
            dataArr.user_phone = input_val;
            dataArr.fn = "user_update";
        }
        $.ajax({
            url: "/php/controller/db_module.php",
            type: "post",
            data: {
                dataArr: dataArr
        },
        }).done(function (data) {
            data = JSON.parse(data);
            if (data.result) {
                alert(`[${GLOBAL_ADMIN_INPUT_TEXT}] 에서 [${input_val}]로/으로 변경하였습니다!`);
            } else {
                alert(`${user_data.msg}`);
            }
        });
    }
});

// user 견적금액, 납부금액 추가와 리스트 조회
$('.amount .btn-group .btn').click(function () {
    const user_no = $(this).data('user--no');
    const btn_type = $(this).data("type");
    const btn_name = $(this).attr('name');
    const element = $(`#${user_no}`).find(`[name="${btn_type}"]`);

    if (btn_name == "form") {
        let btn_text = $(this).text();
        const toggle_text = "취소";
        btn_text = btn_text.includes(toggle_text) ? btn_text.replace(toggle_text, "") : `${btn_text}${toggle_text}`;
        element.find(`.${btn_name}`).toggleClass("flex");
        $(this).text(btn_text);
    }
    if (btn_name == "list") {
        if (element.find(".amount__list").length > 0) {
            element.find(".amount__list").remove();
        } else {
            const dataArr = {fn: "amount_list", user_no: user_no, type: btn_type};
            $.ajax({
                url: "/php/controller/db_module.php",
                type: "post",
                data: {dataArr: dataArr}
            }).done(function (data) {
                data = JSON.parse(data);
                const result = data.result;
                if (result.length == 0) {
                    const swap = (btn_type == "payment") ? "납부금액" : "견적금액";
                    alert(`${swap}의 내역이 없습니다.`);
                } else {
                    element.append(fn_amount_list_html(btn_type, result));
                }
            });
        }
    }
});

// user 견적금액, 납부금액 키업(숫자 숫자만/쉼표)
$('.amount .form input').keyup(function () {
    let char = $(this).val();
    char = fn_only_num(char);
    char = fn_thousand_format(char);
    $(this).val(char);
});

// user 견적금액, 납부금액 추가
$('.amount .form button').click(function () {
    const user_no = $(this).data("user--no");
    const btn_type = $(this).data("type");
    const element = $(`#${user_no}`).find(`[name="${btn_type}"]`);
    const char = element.find('.form input').val();
    const val = fn_only_num(char);
    const dataArr = {fn: "amount_insert", user_no: user_no, type: btn_type, val: val};

    $.ajax({
        url: "/php/controller/db_module.php",
        type: "post",
        data: {
            dataArr: dataArr
        }
    }).done(function (data) {
        data = JSON.parse(data);
        const result = data.result;
        const user_data = result && data.user_data;
        element.find('[name="sum"]').text(fn_thousand_format(user_data));
        element.find('[name="form"]').text("추가");
        element.find('.form input').val("");
        element.find('.form').toggleClass("flex");
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