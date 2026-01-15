$(document).on('click', '.recall-list .more-open', function() {
    $('#user-' + $(this).attr('data-value') + ' .recall-list .more').toggle('show');
    if ($(this).text() == '더보기') {
        $(this).text('줄여보기');
    } else {
        $(this).text('더보기');
    }
});
$('.recall-list .recall-form-open-btn').on('click', function() {
    $('#user-' + $(this).attr('data-value') + ' .recall-form').toggle('show');
    if ($(this).text() == '리콜기록추가') {
        $(this).text('리콜기록닫기');
    } else {
        $(this).text('리콜기록추가');
    }
});
$('.recall-list .cost-form-open-btn').on('click', function() {
    $('#user-' + $(this).attr('data-value') + ' .cost-form').toggle('show');
    if ($(this).text() == '상담계획추가') {
        $(this).text('상담계획닫기');
    } else {
        $(this).text('상담계획추가');
    }
});
$('.recall-list .recall-form-send').on('click', function() {
    let userNo = $(this).attr('data-value');
    let select_comment = $('#user-' + userNo).find('.recall-form').children('select').children('option:selected').val();
    let input_comment = $('#user-' + userNo).find('.recall-form').children('input').val();
    $('#user-' + userNo).find('.empty').detach();
    $('#user-' + userNo).find('.recall-form').toggle('show');
    $('#user-' + userNo).find('.recall-form-open-btn').text('리콜기록추가');
    $.ajax({
        url: "mysql_insert.php",
        type: "post",
        data: {
            functionName: 'user_recall_insert',
            no: parseInt(userNo),
            comment: select_comment
        }
    }).done(function (data) {
        data = JSON.parse(data);
        $('#user-' + userNo).find('.recall-list ul').prepend(
            '<li id="recall-' + data.recallNo + '">'
            + data.recallDate + '&nbsp;'
            + data.comment + '&nbsp;'
            + '<span class="recall-delete" name="' + userNo + '" data-value="' + data.recallNo + '">'
            + '삭제'
            + '</span>'
            + '</li>'
        );
    });
});
$('.recall-list .cost-form-send').on('click', function() {
    let userNo = $(this).attr('data-value');
    let cost = $('#user-' + userNo).find('.cost-form').children('input').val();
    $('#user-' + userNo).find('.cost-form').toggle('show');
    $('#user-' + userNo).find('.cost-form-open-btn').text('상담계획추가');
    $.ajax({
        url: "mysql_update.php",
        type: "post",
        data: {
            functionName: 'user_cost_update',
            no: parseInt(userNo),
            cost: parseInt(cost)
        }
    }).done(function (data) {
        data = JSON.parse(data);
        $('#user-' + userNo).find('td[name="cost"]').text(parseInt(data.cost).toLocaleString('ko-KR'));
    });
});
$(document).on('click', '.recall-list .recall-delete', function() {
    let no = numberExtraction($(this).attr('data-value'));
    let element = $(this);
    $.ajax({
        url: "mysql_update.php",
        type: "post",
        data: {
            functionName: 'user_recall_update',
            no: no
        }
    }).done(function (data) {
        element.parent().detach();
        if ($('#user-' + element.attr('name')).find('.recall-list ul li').length == 0) {
            $('#user-' + element.attr('name')).find('.recall-list ul').append('<li class="empty">리콜내역이 없습니다.</li>');
        }
    });
});

$('#reservation-btn').on('click', function() {
    let name = $('.reservation #reservation-name').val();
    let phone = $('.reservation #reservation-phone').val();
    let referer = $(this).attr('data-referer');
    let regex = /^(01[0-9]{1}-?[0-9]{4}-?[0-9]{4}|01[0-9]{8})$/;
    if (name.length < 2) {
        if (name.length == 0) {
            alert('이름을 입력하세요.');
            $('.reservation #reservation-name').focus();
            return false;
        } else {
            alert('올바르지 않은 이름입니다.');
            $('.reservation #reservation-name').focus();
            return false;
        }
    }
    if (!regex.test(phone)) {
        alert('올바르지 않은 전화번호입니다.');
        $('.reservation #reservation-phone').focus();
        return false;
    }
    $.ajax({
        url: "../db/mysql_insert.php",
        type: "post",
        data: {
            functionName: 'user_call_insert',
            name: name,
            phone: phone,
            referer : referer
        }
    }).done(function (data) {
        data = JSON.parse(data);
        swal(
            '완료!',
            name + '님 <b style="color:green;">감사합니다.</b><br><b style="color:green;">' + phone + '</b>으로 연락드리겠습니다!',
            'success'
        );
        console.log('user call insert 상태 : ' + data.result);
    });
});

function numberExtraction(str) {
    return str.replace(/\D/g, '');
}

$('#reservation-name').on('keyup', function () {
    $(this).val($(this).val().replace(/[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"\\]/g, ""));
});

$('#reservation-phone').on('keyup', function () {
	$(this).val($(this).val().replace(/[^0-9]/gi, "").replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`));
});