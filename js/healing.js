$(document).ready(function (e) {
    fn_teeth_html();
});

$(document).on('click', '.teeth', function(e) {
    const teeth_arr = {
      basic: 0,
      resin: 1,
      inlay: 2,
      crown: 3,
      implant: 4,
      panic: 5
    };
    let teeth_id = Number($(this).attr("id"));
    let teeth_value = Number($(this).attr("data-value")) + 1;
    let teeth_key = getKeyByValue(teeth_arr, teeth_value);
    const teeth_el = $(`#${teeth_id}`);
    const current_src = teeth_el.children("img").attr("src");
    let current_src_arr = current_src.split("/");
    current_src_arr = $.grep(current_src_arr, function(value) {
        return value !== "";
    });
    const last_index = current_src_arr.length - 1;
    current_src_arr.splice(last_index, 1);
    let chang_src = "";
    current_src_arr.forEach(str => {
        chang_src += "/" + str;
    });

    if (teeth_id >= 21 && teeth_id <= 28) {
      teeth_id = teeth_id - 10;
    } else if (teeth_id >= 31 && teeth_id <= 38) {
      teeth_id = teeth_id + 10;
    }

    if (teeth_value == 6) {
        teeth_value = 0;
        teeth_key = "basic";
    }
    chang_src += `/${teeth_id}_${teeth_key}.png`;
    teeth_el.attr("data-value", teeth_value);
    teeth_el.children("img").prop("src" , chang_src);
});

const fn_teeth_html = () => {
    let upper_left_html ="";
    let upper_right_html ="";
    let lower_left_html ="";
    let lower_right_html ="";
    for (let j = 8; j >= 1; j--) {
        const teeth_num = j + 10;
        const class_el = (j >= 6) ? " molar" : "";
        upper_left_html += `<div id="${teeth_num}" class="teeth${class_el}" data-value="0"><img src="/img/teeth/upper/${teeth_num}_basic.png" alt=""></div>`;
        upper_right_html += `<div id="${teeth_num + 10}" class="teeth${class_el}" data-value="0"><img ${class_el} src="/img/teeth/upper/${teeth_num}_basic.png" alt=""></div>`;
    }
    for (let i = 8; i >= 1; i--) {
        const teeth_num = i + 40;
        const class_el = (i >= 6) ? " molar" : "";
        lower_left_html += `<div id="${teeth_num}" class="teeth${class_el}" data-value="0"><img ${class_el} src="/img/teeth/lower/${teeth_num}_basic.png" alt=""></div>`;
        lower_right_html += `<div id="${teeth_num - 10}" class="teeth${class_el}" data-value="0"><img ${class_el} src="/img/teeth/lower/${teeth_num}_basic.png" alt=""></div>`;
    }
    $('#teeth').find('#upper').find('.left').append(upper_left_html);
    $('#teeth').find('#upper').find('.right').append(upper_right_html);
    $('#teeth').find('#lower').find('.left').append(lower_left_html);
    $('#teeth').find('#lower').find('.right').append(lower_right_html);
}

const getKeyByValue = (obj, value) => {
    return Object.keys(obj).find(key => obj[key] === value);
}
