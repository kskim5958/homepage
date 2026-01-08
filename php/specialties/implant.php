<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content implant">
        <ul class="text__group title">
            <li class="text--small text--bold text--orange">임플란트 이벤트</li>
            <li class="text--large text--bold">오스템임플란트&nbsp;<span>일반등급&nbsp;CA&nbsp;25만원&nbsp;이하</span></li>
            <li class="text--large text--bold">오스템임플란트&nbsp;<span>프리미엄&nbsp;BA&nbsp;35만원&nbsp;이하</span></li>
            <li class="text--large text--bold">오스템임플란트&nbsp;<span>프리미엄&nbsp;SOI&nbsp;45만원&nbsp;이하</span></li>
            <li class="text--large text--bold">추가할인 최대 20%</li>
        </ul>
    </section>
    <section class="content implant">
        <div class="media__text__group">
            <div class="media">
                <img src="/img/dr__lee__02.jpg" alt="홍원장님 이미지">
            </div>
            <div class="text__group">
                <div class="text--medium text--bold text--orange">치의학박사 이상민 원장</div>
                <div class="text--large">"임플란트는 치아 뿌리 역할을 하므로 턱뼈와 단단히 결합(골융합)되어야 하며, 이를 위해서는 충분한 골밀도와 골질이 필요합니다."</div>
                <div class="text--small text--bold text--gray"><a href="">대표원장님 이력더보기</a></div>
            </div>
        </div>
    </section>
    <section class="content implant implant__component">
        <div class="title text__group">
            <div class="text--large text--bold">모든 구성 요소를 최고의 브랜드로</div>
            <div class="text--medium">임플란트는 3가지로 구성되며 구성품 하나 하나 최고의 재료로 정성을 다해 시술/수술합니다.</div>
        </div>
        <ul class="component__list">
            <li class="component fixture">
                <div class="media">
                    <img src="/img/implant__fixture__01.png" alt="임플란트 픽스쳐">
                </div>
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트 스크류</div>
                    <div class="text--large text--bold">뿌리역할</div>
                    <div class="text--medium">치아의 뿌리를 역할합니다.</div>
                </div>
            </li>
            <li class="component abutment">
                <div class="media">
                    <img src="/img/implant__abutment__01.png" alt="임플란트 어버트먼트">
                </div>
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트 어버트먼트</div>
                    <div class="text--large text--bold">중간연결장치</div>
                    <div class="text--medium">치아의 뿌리와 인공치아의 연결하는 장치입니다.</div>
                </div>
            </li>
            <li class="component zirconia">
                <div class="media">
                    <img src="/img/implant__zirconia__01.png" alt="임플란트 크라운">
                </div>
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트 크라운</div>
                    <div class="text--large text--bold">인공치아</div>
                    <div class="text--medium">음식물을 씹는 눈에 보여지는 치아형태입니다.</div>
                </div>
            </li>
        </ul>
    </section>
    <section class="content implant">
        <div class="title--text--large wd1200">99%성공률의 임상결과</div>
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
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트</div>
                    <div class="text--large text--bold">당일 임플란트</div>
                    <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
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
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트</div>
                    <div class="text--large text--bold">당일 임플란트</div>
                    <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
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
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트</div>
                    <div class="text--large text--bold">당일 임플란트</div>
                    <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
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
                <div class="text__group">
                    <div class="text--small text--bold text--orange">임플란트</div>
                    <div class="text--large text--bold">당일 임플란트</div>
                    <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                </div>
            </li>
        </ul>
    </section>
    <section class="content implant">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">Slide 1</div>
                <div class="swiper-slide">Slide 2</div>
                <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">Slide 5</div>
                <div class="swiper-slide">Slide 6</div>
                <div class="swiper-slide">Slide 7</div>
                <div class="swiper-slide">Slide 8</div>
                <div class="swiper-slide">Slide 9</div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</div><!-- #Content-List -->
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>