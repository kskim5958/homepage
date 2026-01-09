<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content implant">
        <div class="content__group type__1">
            <div class="text__group">
                <div class="text--large text--bold">하루에 임플란트</div>
                <div class="text--medium text--gray">표면 처리에 칼슘 이온을 더해 임플란트 표면의 친수성을 높여 골유착(뼈와 달라붙는 것) 성능을 향상시킨 임플란트</div>
            </div>
            <div class="media">
                <img src="/img/dr__lee__02.jpg" alt="">
            </div>
        </div>
    </section>
    <section class="content implant implant__type">
        <ul class="text__group">
            <li>
                <div class="text--small text--bold text--orange">오스템임플란트</div>
                <div class="text--large text--bold text--navy--gradient">칼슘임플란트 CA</div>
                <div class="text--medium text--gray">표면 처리에 칼슘 이온을 더해 임플란트 표면의 친수성을 높여 골유착(뼈와 달라붙는 것) 성능을 향상시킨 임플란트</div>
            </li>
            <li>
                <div class="text--small text--bold text--orange">오스템임플란트</div>
                <div class="text--large text--bold text--green--gradient">바이오임플란트 BA</div>
                <div class="text--medium text--gray">표면에 생체 흡수성 재료인 나노 크기의 아파타이트(Apatite)를 코팅하여 초기 골 유착 및 혈액 젖음성을 극대화한 고성능 임플란트</div>
            </li>
            <li>
                <div class="text--small text--bold text--orange">오스템임플란트</div>
                <div class="text--large text--bold text--navy--gradient">칼슘임플란트 SOI</div>
                <div class="text--medium text--gray">표면에 '뼈와 가장 잘 붙는다.'는 의미이며 오스템 임플란트의 최상위 등급 모델로 혈액 젖음성을 극대화하여 빠른 골유착과 치유 기간 단축을 돕는 프리미엄 임플란트</div>
            </li>
        </ul>
    </section>
    <section class="content implant">
        <div class="content__group type__2">
            <div class="media">
                <img src="/img/dr__lee__02.jpg" alt="홍원장님 이미지">
            </div>
            <div class="text__group">
                <div class="text--medium">치의학박사 이상민 원장</div>
                <div class="text--large">"임플란트는 치아 뿌리 역할을 하므로 턱뼈와 단단히 결합(골융합)되어야 하며, 이를 위해서는 충분한 골밀도와 골질이 필요합니다."</div>
            </div>
        </div>
    </section>
    <section class="content implant component">
        <div class="title text__group">
            <div class="text--large text--bold">모든 구성 요소를<br>최고의 브랜드로</div>
            <div class="text--medium">임플란트는 3가지로 구성되며 구성품 하나 하나<br>최고의 재료로 정성을 다해 시술/수술합니다.</div>
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
    <section class="content implant materials">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="media">
                        <video muted autoplay loop>
                            <source src="/video/video__trios__02.mp4" type="video/mp4">
                        </video>
                    </div>
                    <div class="text__group">
                        <div class="text--small text--bold text--orange">임플란트</div>
                        <div class="text--large text--bold">당일 임플란트</div>
                        <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="media">
                        <video muted autoplay loop>
                            <source src="/video/video__trios__02.mp4" type="video/mp4">
                        </video>
                    </div>
                    <div class="text__group">
                        <div class="text--small text--bold text--orange">임플란트</div>
                        <div class="text--large text--bold">당일 임플란트</div>
                        <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="media">
                        <video muted autoplay loop>
                            <source src="/video/video__trios__02.mp4" type="video/mp4">
                        </video>
                    </div>
                    <div class="text__group">
                        <div class="text--small text--bold text--orange">임플란트</div>
                        <div class="text--large text--bold">당일 임플란트</div>
                        <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="media">
                        <video muted autoplay loop>
                            <source src="/video/video__trios__02.mp4" type="video/mp4">
                        </video>
                    </div>
                    <div class="text__group">
                        <div class="text--small text--bold text--orange">임플란트</div>
                        <div class="text--large text--bold">당일 임플란트</div>
                        <div class="text--medium text--gray">더 빠른 속도(가장 빠른 Intel 기반 MacBook Air 대비)</div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</div><!-- #Content-List -->
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>