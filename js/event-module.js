$(document).on('click', '.doctors .text--toggle--btn', function () {
    $(this).parent().children('.text--toggle').toggle('show');
    ($(this).text() == '더보기') ? $(this).text('닫기') : $(this).text('더보기');
});

$('.Media__before__after input[type="range"]').on('input', function () {
    const currentValue = $(this).val(); // 현재 슬라이더 값
    $(this).parent().find('.Media__after').css('width', currentValue + '%');
});