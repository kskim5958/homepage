$(document).ready(function () {

    console.log('Today : ' + formattedDate + ' 요일 : ' + week);
    console.log('접속 url : ' + curl);
    console.log('접속 url path name : ' + pathName);
    console.log('화면 Width : ' + displayWidth);
    console.log('화면 Height : ' + displayHeight);

    let element;
    let other_element;
    let top_spacing;
    let left_spacing;
    let right_spacing;
    let bottom_spacing;
    // if(typeof imgPath == "undefined" || imgPath == null || imgPath == "") alert(1);

    // 공통부분 start
    try {
        $('nav .logo').css('width', (logoWidth * $('nav').height()) / logoHeight + 'px');
        $('nav .logo img').attr('src', logoPath);
        console.log('메뉴(nav) PHP에서 logoWidth, logoPath 초기화 : success');
        element = $('#navigation');
        other_element = $('#user__form');
        right_spacing = element.outerWidth() + extractOnlyNumbers(element.css('right')) + 16;
        bottom_spacing = element.css('bottom');
        other_element.css('right', right_spacing + 'px');
        other_element.css('bottom', bottom_spacing);
        console.log('user__form 위치 : ' + right_spacing + 'px');
    } catch (error) {
        console.log('메뉴(nav) PHP에서 logoWidth, logoPath 초기화 : ' + error);
        console.log('user__form 위치 : ' + error);
    }
    $('#content__list').css('margin-top', navHeight + 'px');
    // 공통부분 end

    switch (pathName) {
        case 'map':
            $('.information .hours li').each(function (index) {
                if ($(this).attr('data-value') == week) {
                    $(this).addClass('text--orange');
                    $(this).find('.selected').show();
                }
            });
            break;
        case 'dr':
            $('.doctors .media').css('height', $('.doctors .media').width() * 1.4 + 'px');
            break;
        case 'equipment':
            element = $('.media__group__list');
            if (displayWidth <= 400) {
                element.find('li').css('width', '100%');
            } else {
                element.find('li').css('width', (element.width() - extractOnlyNumbers(element.css('gap'), 1)) / 2 + 'px');
            }
            element.find('.media').css('height', (element.find('li').width() * 9) / 16 + 'px');
            break;
        case 'implant':
            element = $('.b4af .list');
            if (displayWidth <= 400) {
                element.find('li').css('width', '100%');
            } else {
                element.find('li').css('width', (element.width() - extractOnlyNumbers(element.css('gap'), 1)) / 2 + 'px');                
                element = element.find('.media');
                if (element.length != 0) {
                    element.each(function (index) {
                        let img_original_width = parseInt($(this).attr('data-width'));
                        let img_original_height = parseInt($(this).attr('data-height'));
                        let element_width = element.eq(index).width();
                        element.eq(index).css('height', (img_original_height * element_width) / img_original_width + 'px');
                    });
                }
            }
            element = $('.materials .swiper-slide .media');
            element.css('height', (element.width() * 9) / 16 + 'px');
            break;
        default:
            break;
    }
});