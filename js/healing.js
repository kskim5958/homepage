$(document).ready(function (e) {
    fn_teeth_html();
});

$(document).on('click', '.teeth', function(e) {
    const teeth_arr = {basin : 0, resin : 1, inlay : 2, crown : 3, implant : 4, panic : 5, ext : 6};
    const teeth_id = $(this).attr("id");
    const teeth_val = Number($(this).data("value"));
    const el = $(`#${teeth_id}`).children("img");
    const root = el.attr("src");
    let root_arr = root.split("/");
    root_arr = $.grep(root_arr, function(value) {
        return value !== "";
    });
    const last_index = root_arr.length - 1;
    root_arr.splice(last_index, 1);
    let img_src = "";
    root_arr.forEach(str => {
        img_src += "/" + str;
    });
    img_src += "/" + teeth_id + ".png";
    $.each(teeth_arr, function(key, value) {
        console.log(key + ": " + value);
    });
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
    for (let i = 1; i <= 8; i++) {
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