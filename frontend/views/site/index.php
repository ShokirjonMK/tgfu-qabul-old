<?php
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'TOSHKENT GUMANITAR FANLAR UNIVERSITETI';
?>

<div class="mainPage">
    <div class="ban_content">
        <div class="ik_home_slider">
            <div class="ik_home_slider_left">
                <h1  data-aos="fade-up" data-aos-duration="2000">Toshkent</h1>
                <h1  data-aos="fade-up" data-aos-duration="2000" data-aos-delay="100">Gumanitar Fanlar2</h1>
                <h1  data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">Universiteti <span><?= Yii::t("app" , "a155") ?></span></h1>
                <div class="ik_hm_link">
                    <div class="ik_home_slider_left_link" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="300">
                        <a href="<?= Url::to(['site/login']) ?>"><span class="ik_hslider_span_one"><?= Yii::t("app" , "a4") ?></span> <span class="ik_hslider_span_second"></span><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="ik_home_slider_right">
                <img src="/frontend/web/images/tgfu_girls.png" class="tgfu_girls" data-aos="zoom-in"  data-aos-duration="2000">

                <img src="/frontend/web/images/banner-cap.png" class="tgfu_cap tg_none">
                <img src="/frontend/web/images/banner-star.png" class="tgfu_star tg_none">
                <img src="/frontend/web/images/banner-map.png" class="tgfu_map tg_none">
                <img src="/frontend/web/images/banner-book.png" class="tgfu_book tg_none">

                <div class="ik_take_now">
                    <div class="ik_take_now_item">
                        <div class="ik_take_now_user">
                            <img src="/frontend/web/images/banner-author.png" alt="">
                        </div>
                        <div class="ik_take_now_content">
                            <p><?= Yii::t("app" , "a156") ?> <br> <small><?= Yii::t("app" , "a157") ?></small></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="ik_hm_slider_box" data-aos="zoom-in-up" data-aos-duration="2000">
            <div class="ik_hm_slider_box_child"></div>
        </div>
        <div class="ik_tomchi ik_tomchi_bottom"></div>
        <div class="ik_tomchi ik_tomchi_top"></div>
    </div>
</div>


<?= $this->render('_content') ; ?>