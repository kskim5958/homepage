<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/herder.php'; ?>
<div id="content__list">
    <section class="content__outer main__title">
        <div class="content__group">
            <div class="content">
                <div class="text__group">
                    <h2>오스템임플란트</h2>
                    <h1>단, 25만원</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content__outer dentist">
        <div class="content__group">
            <div class="content">
                <div class="text__group">
                    <div class="group">
                        <h1>치의학박사, 경희치과병원 교수<br>임플란트전문의, 오스템인정의</h1>
                        <p>다년간의 임플란트 수술 경험과 다양한 케이스를 다뤄본 의료진을 선택하세요. 단순히 많은 임플란트를 심는 것보다 전후 사진을 통해 장기적인 결과를 보여줄 수 있는 곳이 좋습니다.</p>
                    </div>
                    <div class="group">
                        <div class="group__sub">
                            <h2>99%</h2>
                            <p>임플란트<br>성공케이스</p>
                        </div>
                        <div class="group__sub">
                            <h2>12,000+</h2>
                            <p>임플란트<br>식립케이스</p>
                        </div>
                        <div class="group__sub">
                            <h2>20년</h2>
                            <p>임플란트<br>경력</p>
                        </div>
                    </div>
                </div>
                <div class="media">
                    <img src="/img/sample__model__doctor__1.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="content__outer implant type">
        <div class="content__group">
            <div class="content">
                <div class="media">
                    <img src="/img/implant__fixture__01.png" alt="">
                </div>
            </div>
            <div class="content label">
                <div class="text__group">
                    <h5>오스템임플란트</h5>
                    <h1>칼슘임플란트</h1>
                    <p>표면 처리에 칼슘 이온을 더해 임플란트 표면의 친수성을 높여 골유착(뼈와 달라붙는 것) 성능을 향상시킨 임플란트</p>
                </div>
                <div class="text__group">
                    <h5>오스템임플란트</h5>
                    <h1>칼슘임플란트</h1>
                    <p>표면 처리에 칼슘 이온을 더해 임플란트 표면의 친수성을 높여 골유착(뼈와 달라붙는 것) 성능을 향상시킨 임플란트</p>
                </div>
                <div class="text__group">
                    <h5>오스템임플란트</h5>
                    <h1>칼슘임플란트</h1>
                    <p>표면 처리에 칼슘 이온을 더해 임플란트 표면의 친수성을 높여 골유착(뼈와 달라붙는 것) 성능을 향상시킨 임플란트</p>
                </div>
            </div>
        </div>
    </section>
    <section class="content__outer implant composition">
        <div class="content__group title">
            <div class="content">
                <div class="text__group">
                    <h1>모든 구성요소를 최고의 재료로<br>정성을 다합니다.</h1>
                    <p>본원은 임플란트를 구성하는 모든 요소에 정성을 다해 치아의 원래 기능을 회복시키는데 최선을 다합니다.</p>
                </div>
            </div>
        </div>
        <div class="content__group">
            <div class="content">
                <div class="media">
                    <img src="/img/implant__fixture__01.png" alt="">
                </div>
                <div class="text__group">
                    <h5>임플란트 픽스쳐</h5>
                    <h2>뿌리역할</h2>
                    <p>치아의 뿌리부분 역할을 하는 가장 중요한 부위입니다.</p>
                    <h2>25만원부터</h2>
                </div>
            </div>
            <div class="content">
                <div class="media">
                    <img src="/img/implant__abutment__01.png" alt="">
                </div>
                <div class="text__group">
                    <h5>임플란트 어버트먼트</h5>
                    <h2>중간연결장치</h2>
                    <p>치아의 뿌리와 인공치아의 연결하는 장치입니다.</p>
                    <h2>맞춤형 무료제작</h2>
                </div>
            </div>
            <div class="content">
                <div class="media">
                    <img src="/img/implant__zirconia__01.png" alt="">
                </div>
                <div class="text__group">
                    <h5>임플란트 크라운</h5>
                    <h2>씹는 인공치아</h2>
                    <p>치아의 뿌리부분 역할을 하는 가장 중요한 부위입니다.</p>
                    <h2>맞춤형 무료제작</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="content__outer implant b4af">
        <div class="content__group title">
            <div class="content">
                <div class="text__group">
                    <h1>모든 구성요소를 최고의 재료로<br>정성을 다합니다.</h1>
                    <p>본원은 임플란트를 구성하는 모든 요소에 정성을 다해 치아의 원래 기능을 회복시키는데 최선을 다합니다.</p>
                </div>
            </div>
        </div>
        <ul class="content__group">
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
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/php/main/footer.php'; ?>