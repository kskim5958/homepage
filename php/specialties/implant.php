0<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="Content-List">
    <section class="content implant">
        <ul class="text__group">
            <li class="text--small text--bold text--orange">임플란트 이벤트</li>
            <li class="text--large text--bold">오스템임플란트SA 25만원 이하</li>
            <li class="text--large text--bold">오스템임플란트 프리미엄BA 35만원 이하</li>
            <li class="text--large text--bold">오스템임플란트 프리미엄SOI 45만원 이하</li>
            <li class="text--large text--bold">추가할인 최대 20%</li>
        </ul>
    </section>
    <section class="content implant">
        <ul class="b4bc__group__list">
            <li>
                <?php
                    $croot = $_SERVER["DOCUMENT_ROOT"];
                    $img_b = '/img/comparison__implant__01__before.jpg';
                    $img_a = '/img/comparison__implant__01__after.jpg';
                    $img_i = getimagesize($croot . $img_b);
                    $img_w = $img_i[0];
                    $img_h = $img_i[1];
                ?>
                <div class="media" data-width="<?php echo $img_w ?>" data-height="<?php echo $img_h ?>">
                    <div class="media__b4" style="background-image: url(<?php echo $img_b ?>);">
                        <div class="media__bc" style="background-image: url(<?php echo $img_a ?>);"></div>
                    </div>
                    <input type="range" min="0" max="100" value="50">
                </div>
                <div class="Text__group">
                    <div class="text--small">임플란트</div>
                    <div class="text--large">당일 임플란트</div>
                    <div class="text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </div>
            </li>
            <li>
                <?php
                    $croot = $_SERVER["DOCUMENT_ROOT"];
                    $img_b = '/img/comparison__implant__01__before.jpg';
                    $img_a = '/img/comparison__implant__01__after.jpg';
                    $img_i = getimagesize($croot . $img_b);
                    $img_w = $img_i[0];
                    $img_h = $img_i[1];
                ?>
                <div class="media" data-width="<?php echo $img_w ?>" data-height="<?php echo $img_h ?>">
                    <div class="media__b4" style="background-image: url(<?php echo $img_b ?>);">
                        <div class="media__bc" style="background-image: url(<?php echo $img_a ?>);"></div>
                    </div>
                    <input type="range" min="0" max="100" value="50">
                </div>
                <div class="Text__group">
                    <div class="text--small">임플란트</div>
                    <div class="text--large">당일 임플란트</div>
                    <div class="text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </div>
            </li>
        </ul>            
    </section>
</div><!-- #Content-List -->
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>