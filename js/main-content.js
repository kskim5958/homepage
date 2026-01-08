$(document).ready(function () {

    console.log('Today : ' + formattedDate + ' 요일 : ' + week);
    console.log('접속 url : ' + curl);
    console.log('접속 url path name : ' + pathName);
    console.log('화면 Width : ' + displayWidth);
    console.log('화면 Height : ' + displayHeight);

    // if(typeof imgPath == "undefined" || imgPath == null || imgPath == "") alert(1);

    // 공통부분 start
    try {
        $('nav .Logo').css('width', (logoWidth * $('nav').height()) / logoHeight + 'px');
        $('nav .Logo img').attr('src', logoPath);
        console.log('메뉴(nav) PHP에서 logoWidth, logoPath 초기화 : success');
    } catch (error) {
        console.log('메뉴(nav) PHP에서 logoWidth, logoPath 초기화 : ' + error);
    }
    $('#content__list').css('margin-top', navHeight + 'px');
    // 공통부분 end

    let element;
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
            element = $('.b4bc__group__list');
            if (displayWidth <= 400) {
                element.find('li').css('width', '100%');
            } else {
                element.find('li').css('width', (element.width() - extractOnlyNumbers(element.css('gap'), 1)) / 2 + 'px');                
                element = $('.b4bc__group__list').find('.media');
                if (element.length != 0) {
                    element.each(function (index) {
                        let img_original_width = parseInt($(this).attr('data-width'));
                        let img_original_height = parseInt($(this).attr('data-height'));
                        let element_width = element.eq(index).width();
                        element.eq(index).css('height', (img_original_height * element_width) / img_original_width + 'px');
                    });
                }
            }
            break;
        default:
            break;
    }
});