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
    char = String(char).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

// const fn_amount_list_html = (btn_type, list)  =>{
//     let html = "";
//     if (list.length != 0) {
//         html = `<ul class="list amount__list">`;
//         list.forEach((item, index) => {
//             html += `<li>
//                 <span class="item">${item.reg_dt} [${fn_thousand_format(item[btn_type])}원]</span>
//                 <span class="btn" name="del" data-btn--type="${btn_type}" data-user--no="${item.user_no}" data-no="${item.no}">삭제</span>
//                 </li>`;
//         });
//         html += "</ul>";
//     }
//     return html;
// }

// const fn_recall_list_html = (list)  =>{
//     let html = "";
//     if (list.length != 0) {
//         html = `<ul class="list recall__list">`;
//         list.forEach((recall, index) => {
//             html += `<li>
//                 <span class="item">${recall.reg_dt} ${recall.comment}</span>
//                 <span class="btn" name="del" data-btn--type="recall" data-user--no="${recall.user_no}" data-no="${recall.no}">삭제</span>
//                 </li>`;
//         });
//         html += "</ul>";
//     }
//     return html;
// }

const fn_null_besides = (val)  =>{
    let result = false;
    result = (val === null && typeof val === "undefined") ? true : false;
    if (typeof val === "string") {
        val = val.replace(" ", "");
        result = (val === "") ? true : false;
    }
    return result;
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

user_el.find('[name="user_name"]').find("input").keyup(function () {
    let char = $(this).val();
    char = fn_kor_format(char);
    $(this).val(char);
});

user_el.find('[name="user_phone"]').find("input").keyup(function () {
    let char = $(this).val();
    char = fn_phone_format(char);
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
        result ? alert(`${user_name}님, ${user_phone} 연락처로 등록하였습니다!`) : alert('등록에 실패하였습니다!');
    });
    window.location.href = path;
});

// user 상태 업데이트
user_el.find('select[name="user_type"]').change(function (e) { 
    const user_no = $(this).data('user--no');
    const btn_name = $(this).data("btn--name");
    const val = $(this).val();
    let dataArr ={fn: 'user_update', user_no: user_no};
    dataArr.btn_name = btn_name;
    dataArr.val = val;

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
            const user_arr = data.user_arr;
            alert(`${user_arr.user_name}님의 상태를 [${user_arr.user_comment}]로/으로 변경하였습니다!`);
        } else {
            alert("업데이트에 실패하였습니다.\n콘솔로그를 확인하세요!");
            console.log(data.error);
        }
    });
});

// 유저 이름, 휴대폰번호 업데이트
user_el.find('[name="user_name"] .btn, [name="user_phone"] .btn').click(function (event) {
    const target = $(event.target);
    const user_no = target.data("user--no");;
    const btn_name = target.data("btn--name");
    const element = $(`#${user_no} [name="${btn_name}"]`);
    const val = element.find("input").val();
    let dataArr ={fn: 'user_update', user_no: user_no};
    element.find(".btn").toggle();
    if (target.hasClass("update")) {
        GLOBAL_ADMIN_INPUT_TEXT = val;
        fn_update_input_css("active", element.find("input"));
    }
    if (target.hasClass("close")) {
        fn_update_input_css("inactive", element.find("input"));
        element.find("input").val(GLOBAL_ADMIN_INPUT_TEXT);
    }
    if (target.hasClass("action")) {
        fn_update_input_css("inactive", element.find("input"));
        if (btn_name == "user_name") {
            dataArr.btn_name = btn_name;
            dataArr.val = val;
        }
        if (btn_name == "user_phone") {
            dataArr.btn_name = btn_name;
            dataArr.val = val;
        }
        $.ajax({
            url: "/php/controller/db_module.php",
            type: "post",
            data: {
                dataArr: dataArr
        },
        }).done(function (data) {
            data = JSON.parse(data);
            const result = data.result;
            if (result) {
                alert(`[${GLOBAL_ADMIN_INPUT_TEXT}] 에서 [${val}]로/으로 변경하였습니다!`);
            } else {
                alert("업데이트에 실패하였습니다.\n콘솔로그를 확인하세요!");
                console.log(data.error);
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

                if (result) {
                    const list = data.list;
                    if (list.length == 0) {
                        const swap = (btn_type == "payment") ? "납부금액" : "견적금액";
                        alert(`${swap}의 내역이 없습니다.`);
                    } else {
                        element.append(fn_amount_list_html(btn_type, list));
                    }
                } else {
                    alert("납부금 추가/조회에 실패하였습니다.\n콘솔로그를 확인하세요!");
                    console.log(data.error);
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
        if (result) {
            const amount_sum = data.amount_sum;
            element.find('[name="sum"]').find('.val').text(fn_thousand_format(amount_sum[btn_type]));
            element.find('[name="form"]').text("추가");
            element.find('.form input').val("");
            element.find('.form').toggleClass("flex");
            if (element.find(".amount__list").length > 0) {
                element.find(".amount__list").remove();
            }
        } else {
            alert("납부금 추가/조회에 실패하였습니다.\n콘솔로그를 확인하세요!");
            console.log(data.error);
        }
    });
    
});

// user 리콜리스트 조회
$('.recall .btn-group .btn').click(function () {
    const user_no = $(this).data('user--no');
    const btn_name = $(this).attr('name');
    const element = $(`#${user_no}`).find(`[name="recall"]`);

    if (btn_name == "form") {
        let btn_text = $(this).text();
        const toggle_text = "취소";
        btn_text = btn_text.includes(toggle_text) ? btn_text.replace(toggle_text, "") : `${btn_text}${toggle_text}`;
        element.find(`.${btn_name}`).toggleClass("flex");
        $(this).text(btn_text);
    }
    if (btn_name == "list") {
        if (element.find(".recall__list").length > 0) {
            element.find(".recall__list").remove();
        } else {
            const dataArr = {fn: "recall_list", user_no: user_no};
            $.ajax({
                url: "/php/controller/db_module.php",
                type: "post",
                data: {dataArr: dataArr}
            }).done(function (data) {
                data = JSON.parse(data);
                const result = data.result;
                if (result) {
                    const list = data.list;
                    if (list.length == 0) {
                        alert(`리콜내역이 없습니다.`);
                    } else {
                        element.append(fn_recall_list_html(list));
                    }
                } else {
                    alert("리콜 추가/조회에 실패하였습니다.\n콘솔로그를 확인하세요!");
                    console.log(data.error);
                }
            });
        }
    }
});

// user 리콜추가
$('.recall .form button[name="insert"]').click(function () {
    const user_no = $(this).data("user--no");
    const btn_type = "recall"
    const element = $(`#${user_no}`).find(`[name="${btn_type}"]`);
    const select_val = element.find('select[name="recall_type"]').children("option:selected").text();
    const input_val = (element.find('input[name="recall_text"]').val()).replace(" ", "");
    const comment = (input_val == "") ? select_val : input_val;
    const dataArr = {fn: "recall_insert", user_no: user_no, comment: comment};

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
            alert("리콜등록을 완료하였습니다.");
        } else {
            alert("리콜등록을 실패하였습니다.\n콘솔로그를 확인하세요!");
            console.log(data.error);
        }
    });
});

// user 납부금 삭제, 리콜 삭제
$(document).on("click", '.user__information .list .btn', function (event) {
    const target = $(event.target);
    const btn_type = target.data("btn--type");
    let fn = `${btn_type}_update`;
    if (btn_type == "estimate" || btn_type == "payment") {
        fn = "amount_update";
    }
    const user_no = target.data("user--no");
    const no = target.data("no");
    const element = $(`#${user_no}`).find(`[name="${btn_type}"]`);
    const dataArr = {fn: fn, no: no, user_no: user_no, type: btn_type};

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
            const list = data.list;
            const error = data.error;
            fn_reorder_list(element, list, btn_type);
            if (error.length != 0) {
                error.forEach((msg, index) => {
                    console.log(`[${index}] ${msg}`)
                });
            }
        } else {
            console.log(data.error);
        }
    });
});

const fn_reorder_list = (element, list, type) => {
    const list_type = (type == "recall") ? type : "amount";
    const class_el = element.find(`.${list_type}__list`);
    const has_class = (class_el.length > 0) ? true : false;
    let html = "";
    if (list.length != 0) {
        if (has_class) {
            class_el.remove();
            if (type == "recall") {
                const del_btn = (class_el.find('[name="del"]').length > 0) ? true : false;
                if (del_btn) {
                    html = fn_recall_list_html(list);
                } else {
                    html = fn_recall_list_basic_html(list);
                }
            } else {
                html = fn_amount_list_html(type, list);
            }
            element.append(html);
        }
    } else {
        class_el.remove();
    }
    if (type == "recall") {
        element.find('[name="sum"]').find('.val').text(list.length);
    } else {
        let sum = 0;
        list.forEach(item => {
            sum += parseInt(item[type]);
        });
        element.find('[name="sum"]').find('.val').text(sum);
    }
}

const fn_amount_list_html = (type, list)  =>{
    let html = "";
    let sum = 0;
    if (list.length != 0) {
        html = `<ul class="list amount__list">`;
        list.forEach((item, index) => {
            html += `<li>
                <span class="item">${item.reg_dt} [${fn_thousand_format(item[type])}원]</span>
                <span class="btn" name="del" data-btn--type="${type}" data-user--no="${item.user_no}" data-no="${item.no}">삭제</span>
                </li>`;
        });
        html += "</ul>";
    }
    return html;
}

const fn_recall_list_html = (list)  =>{
    let html = "";
    if (list.length != 0) {
        html = `<ul class="list recall__list">`;
        list.forEach((recall, index) => {
            html += `<li>
                <span class="item">${recall.reg_dt} ${recall.comment}</span>
                <span class="btn" name="del" data-btn--type="recall" data-user--no="${recall.user_no}" data-no="${recall.no}">삭제</span>
                </li>`;
        });
        html += "</ul>";
    }
    return html;
}

const fn_recall_list_basic_html = (list)  =>{
    let html = "";
    if (list.length != 0) {
        html = `<ul class="list recall__list">`;
        html += `<li><span class="item">${list[0].reg_dt} ${list[0].comment}</span></li>`;
        html += "</ul>";
    }
    return html;
}