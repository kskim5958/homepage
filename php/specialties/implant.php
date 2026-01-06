<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
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
    <hr class="wd--90 mg--type--01 color--gray">
    <section class="Content">
        <div class="Implant">
            <ul class="Implant__title">
                <li>
                    <div class="Text--title--small">오스템임플란트 CA</div>
                    <div class="Text--title--large">25</div>
                </li>
                <li>
                    <div class="Text--small">NEW 트리오스</div>
                    <div class="Text--large Text--navy--gradient">FULL HD</div>
                    <div class="Text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </li>
                <li>
                    <div class="Text--small">NEW 아이테로</div>
                    <div class="Text--large Text--navy--gradient">6개의<br>고화질카메라</div>
                    <div class="Text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </li>
                <li>
                    <div class="Text--small">4K고화질</div>
                    <div class="Text--large Text--green--gradient">1만5천배</div>
                    <div class="Text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </li>
            </ul><!-- Implant__title end -->
            <ul class="Implant__content__list">
                <li>
                    <div class="Implant__content">
                        <div class="Text__group">
                            <div class="Text--small">임플란트</div>
                            <div class="Text--large">당일 임플란트</div>
                            <div class="Text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                        </div>
                        <?php
                        $croot = $_SERVER["DOCUMENT_ROOT"];
                        $img_b = '/img/comparison__implant__01__before.jpg';
                        $img_a = '/img/comparison__implant__01__after.jpg';
                        $img_i = getimagesize($croot . $img_b);
                        $img_w = $img_i[0];
                        $img_h = $img_i[1];
                        ?>
                        <div class="Media__before__after" data-width="<?php echo $img_w ?>" data-height="<?php echo $img_h ?>">
                            <div class="Media__before" style="background-image: url(<?php echo $img_b ?>);">
                                <div class="Media__after" style="background-image: url(<?php echo $img_a ?>);"></div>
                            </div>
                            <input type="range" min="0" max="100" value="50">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="Implant__content">
                        <div class="Text__group">
                            <div class="Text--small">임플란트</div>
                            <div class="Text--large">당일 임플란트</div>
                            <div class="Text--medium">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                        </div>
                        <?php
                        $croot = $_SERVER["DOCUMENT_ROOT"];
                        $img_b = '/img/comparison__implant__01__before.jpg';
                        $img_a = '/img/comparison__implant__01__after.jpg';
                        $img_i = getimagesize($croot . $img_b);
                        $img_w = $img_i[0];
                        $img_h = $img_i[1];
                        ?>
                        <div class="Media__before__after" data-width="<?php echo $img_w ?>" data-height="<?php echo $img_h ?>">
                            <div class="Media__before" style="background-image: url(<?php echo $img_b ?>);">
                                <div class="Media__after" style="background-image: url(<?php echo $img_a ?>);"></div>
                            </div>
                            <input type="range" min="0" max="100" value="50">
                        </div>
                    </div>
                </li>
            </ul><!-- Implant__content end -->
        </div>
    </section>
</div><!-- #Content-List -->
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>