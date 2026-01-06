<script>
    <?php
    $imgPath = '/img/logo__01.png';
    $imgSize = getimagesize($_SERVER["DOCUMENT_ROOT"] . $imgPath);
    echo 'var logoWidth = ' . $imgSize[0] . ';';
    echo 'var logoHeight = ' . $imgSize[1] . ';';
    echo 'var logoPath = "' . $imgPath . '";';
    ?>
</script>
<nav class="Text--small">
    <div class="nav__inner">
        <div class="Logo">
            <img>
        </div>
        <ul class="Menu">
            <li>
                <div class="Menu__main">
                    <a>치과소개</a>
                </div>
            </li>
            <li>
                <div class="Menu__main">
                    <a>임플란트</a>
                </div>
            </li>
            <li>
                <div class="Menu__main">
                    <a>치아교정</a>
                </div>
            </li>
            <li>
                <div class="Menu__main">
                    <a>자연치아살리기</a>
                </div>
            </li>
            <li>
                <div class="Menu__main">
                    <a>서비스</a>
                </div>
            </li>
            <li>
                <div class="Menu__main">
                    <a>네이버플레이스</a>
                </div>
            </li>
        </ul>
        <div class="Icon"></div>
    </div>
</nav>