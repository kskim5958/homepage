<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="Content-List">
    <section class="content map">
        <div class="text__title">
            <div class="text--large text--bold">미소더예쁨치과</div>
            <div class="text--medium">평일 오전 10시 부터 오후 7시까지</div>
        </div>
    </section>
    <section class="content map">
        <div id="map"></div>
    </section>
    <section class="content map">
        <div class="information">
            <ul class="address">
                <li class="title">주소</li>
                <li>수원시 권선구</li>
                <li>권선동 960 1층</li>
                <li>경수대로 393 1층</li>
                <li><a href="tel:16611361">1661-1361</a></li>
                <li>수원시청역 5번 출구에서 627m</li>
                <li>81번, 202번, 300번, 300-1번</li>
            </ul>
            <ul class="hours">
                <li class="title">진료시간</li>
                <li data-value="1"><div class="week">월요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="2"><div class="week">화요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="3"><div class="week">수요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="4"><div class="week">목요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="5"><div class="week">금요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="6"><div class="week">토요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
                <li data-value="0"><div class="week">일요일</div><div class="time">10:00 오전 - 07:00 오후&nbsp;<span class="selected">*</span></div></li>
            </ul>
            <ul class="help">
                <li class="title">도움말</li>
                <li>자신에게 맞는 제품을 고르는 데 도움이 필요하지만, 매장에 들를 시간이 없으신가요? 스페셜리스트가 도움을 주는 온라인 일대일 세션에 참여해 보세요.</li>
                <li>자신에게 맞는 제품을 고르는 데 도움이 필요하지만, 매장에 들를 시간이 없으신가요? 스페셜리스트가 도움을 주는 온라인 일대일 세션에 참여해 보세요.</li>
            </ul>
        </div>
    </section>
</div><!-- #Content-List -->
<script src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpKeyId=w63lf8m9yc"></script>
<script>
    var HOME_PATH = window.HOME_PATH || '.';

    var cityhall = new naver.maps.LatLng(37.261696, 127.024079),
        map = new naver.maps.Map('map', {
            center: cityhall.destinationPoint(0, 500),
            zoom: 15
        }),
        marker = new naver.maps.Marker({
            map: map,
            position: cityhall
        });

    var contentString = [
        '<div class="iw_inner">',
        '   <h5>미소더예쁨치과</h5>',
        '   <p>수원시 권선구 권선동 960 | 수원시 권선구 권선로 393 1층<br />',
        '       대표번호 1661-1361 | 보건복지부인정, 수원대표치과<br />',
        '       <a href="http://www.yeppeum.co.kr" target="_blank">www.yeppeum.co.kr</a>',
        '   </p>',
        '</div>'
    ].join('');

    var infowindow = new naver.maps.InfoWindow({
        content: contentString
    });

    naver.maps.Event.addListener(marker, "click", function(e) {
        if (infowindow.getMap()) {
            infowindow.close();
        } else {
            infowindow.open(map, marker);
        }
    });

    infowindow.open(map, marker);
</script>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>