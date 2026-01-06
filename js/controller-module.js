try {
    var curl = log__path().curl;
    var pathName = log__path().pathName;

    var displayWidth = $(window).width();
    var displayHeight = $(window).height();

    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    var week = today.getDay();
    var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);

    var navHeight = $('nav').height();
    var contentWidth = $('#Content-List').outerWidth();
    var contentHeight = $('#Content-List').outerHeight();
} catch (error) {
    console.log('변수 초기화 : ' + error);
}

function log__path() {
    let curl = window.location.pathname;
    let curl_ls = curl.split('/');
    let pathName = curl_ls[curl_ls.length - 1].split('.')[0];
    return {curl: curl, pathName: pathName};
}

function extractOnlyNumbers(str, index) {
    if (str.includes(' ')) {
        str = str.split(' ')[index];
    }
    return parseInt(str.replace(/[^0-9]/g, ''));
}
/*
function getDayOfWeek(dateString) {
    var date = new Date(dateString); // 'YYYY-MM-DD' 형식으로 Date 객체 생성
    var days = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];
    return days[date.getDay()];
}

console.log(getDayOfWeek('2025-12-31')); // 수요일
console.log(getDayOfWeek('2026-01-01')); // 목요일
*/

// const observer = new IntersectionObserver((entries, observer) => {
//   entries.forEach(entry => {
//     if (entry.isIntersecting) {
//       console.log('요소가 화면에 보이기 시작했습니다!');
//       // 여기서 이미지 로드 등 실제 작업을 수행하고 옵저버를 해제할 수 있습니다.
//       observer.unobserve(entry.target);
//     }
//   });
// });
// const targetElement = document.querySelector('.lazy-image');
// observer.observe(targetElement);