<?php
use yii\helpers\Url;
use common\models\Languages;
use common\models\Student;
use yii\helpers\Html;
$languages = Languages::find()->where(['is_deleted' => 0, 'status' => 1])->all();
$lang = Yii::$app->language;
$langId = 1;
if ($lang == 'ru') {
    $langId = 3;
} elseif ($lang == 'en') {
    $langId = 2;
}
/** @var $student  */
/** @var $class  */
?>
<div class="head_mobile">
    <div class="root-item">
        <div class="ik_hd">
            <div class="ik_hd_left">
                <div class="mb_head_left">
                    <a href="<?= Url::to(['site/index']) ?>">
                        <img src="/frontend/web/images/tgfu-logo-notext_white.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="ik_hd_center">
                <ul>
                    <?php if (isset($student)): ?>
                        <li>
                            <a href="<?= Url::to(['cabinet/index']) ?>" data-aos="zoom-in" data-aos-duration="1000">
                                <p><?= Yii::t("app" , "a40") ?></p>
                                <span></span>
                            </a>
                        </li>
                        <?php if ($student->edu_type_id == 1) : ?>
                            <li>
                                <a href="<?= Url::to(['cabinet/exam']) ?>" data-aos="zoom-in" data-aos-duration="1000">
                                    <p><?= Yii::t("app" , "a43") ?></p>
                                    <span></span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?= Url::to(['cabinet/send-file']) ?>" data-aos="zoom-in" data-aos-duration="1000">
                                    <p><?= Yii::t("app" , "a44") ?></p>
                                    <span></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="<?= Url::to(['cabinet/download-file']) ?>" data-aos="zoom-in" data-aos-duration="1000">
                                <p><?= Yii::t("app" , "a46") ?></p>
                                <span></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['cabinet/connection']) ?>" data-aos="zoom-in" data-aos-duration="1000">
                                <p><?= Yii::t("app" , "a47") ?></p>
                                <span></span>
                            </a>
                        </li>
                        <li>
                            <?= Html::a('<p>'.Yii::t("app" , "a41").'</p><span></span>', ['site/logout'], [
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </li>
                    <?php else: ?>
                        <li><a href="tel:+998788886666" data-aos="zoom-in" data-aos-duration="1000"><p><?= Yii::t("app" , "a2") ?></p> <span></span></a></li>
                        <li><a href="#ik_direc" data-aos="zoom-in" data-aos-duration="1000"><p><?= Yii::t("app" , "a3") ?></p> <span></span></a></li>
                        <li><a href="<?= Url::to(['site/login']) ?>" data-aos="zoom-in" data-aos-duration="1000"><p><?= Yii::t("app" , "a4") ?></p> <span></span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="ik_hd_right">
                <div class="mb_head_right">
                    <div class="translation cab_flag" style="background: #6A78FF;">
                        <div class="dropdown">

                            <button class="dropdown-toggle link-hover" style="background: none;" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <?php foreach ($languages as $language): ?>
                                    <?php if ($language->id == $langId): ?>
                                        <p style="color: #fff;"><?= $language['name_'.$lang] ?></p>
                                        <?php if ($language->id == 1): ?>
                                            <img src="/frontend/web/images/uzb.png" alt="">
                                        <?php elseif ($language->id == 2) : ?>
                                            <img src="/frontend/web/images/eng1.png" alt="">
                                        <?php elseif ($language->id == 3) : ?>
                                            <img src="/frontend/web/images/rus.png" alt="">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </button>

                            <ul class="dropdown-menu">
                                <ul class="drop_m_ul">
                                    <?php foreach ($languages as $language): ?>
                                        <?php if ($language->id != $langId): ?>
                                            <li>
                                                <a href="<?= Url::to(['site/lang' , 'id' => $language->id]) ?>">
                                                    <span><?= $language['name_'.$lang] ?></span>
                                                    <?php if ($language->id == 1): ?>
                                                        <img src="/frontend/web/images/uzb.png" alt="">
                                                    <?php elseif ($language->id == 2) : ?>
                                                        <img src="/frontend/web/images/eng1.png" alt="">
                                                    <?php elseif ($language->id == 3) : ?>
                                                        <img src="/frontend/web/images/rus.png" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="close_nav display_show">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <?php if (!isset($student)): ?>
            <div class="ik_ijtimoiy">
                <div class="mb_menu_list">
                    <ul>
                        <li data-aos="fade-left"><a href="https://www.instagram.com/tgfu_uz/?igshid=MzRlODBiNWFlZA%3D%3D"><i class="fa-brands fa-instagram"></i></a></li>
                        <li data-aos="fade-left" data-aos-delay="100"><a href="https://t.me/tgfu_uzb"><i class="fa-brands fa-telegram"></i></a></li>
                        <li data-aos="fade-left" data-aos-delay="200"><a href="https://www.facebook.com/tgfu.uz?mibextid=ZbWKwL"><i class="fa-brands fa-facebook"></i></a></li>
                        <li data-aos="fade-left" data-aos-delay="300"><a href="https://youtube.com/@tgfuofficial?si=teblBgMHa0fG-nus"><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<div id="sidebar" class="root_left">
    <div class="sidebar-item">
        <div class="close_button">
            <span></span>
            <span></span>
        </div>
        <div class="ik_sidebar_content">
            <div class="ik_sidebar_content_item">

                <div class="ik_sidebar_margin">
                    <div class="mb_head_left">
                        <a href="<?= Url::to(['site/index']) ?>">
                            <img src="/frontend/web/images/tgfu-logo-notext_white.svg" alt="">
                        </a>
                    </div>
                    <h5>Toshkent Gumanitar Fanlar Universiteti</h5>
                    <div class="ik_sidebar_ul">

                        <div class="ik_sidebar_list">
                            <p><?= Yii::t("app" , "a1") ?></p>
                            <ul>
                                <li>
                                    <a href="<?= Url::to(['cabinet/index']) ?>">
                                        <i class="fa-solid fa-file-import"></i>
                                        <span><?= Yii::t("app" , "a40") ?></span>
                                    </a>
                                </li>
                                <?php if (isset($student)) : ?>
                                    <?php if ($student->edu_type_id == 1) : ?>
                                        <li>
                                            <a href="<?= Url::to(['cabinet/exam']) ?>">
                                                <i class="fa-solid fa-file-import"></i>
                                                <span><?= Yii::t("app" , "a43") ?></span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?= Url::to(['cabinet/send-file']) ?>">
                                                <i class="fa-solid fa-file-import"></i>
                                                <span><?= Yii::t("app" , "a44") ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <li>
                                        <a href="<?= Url::to(['cabinet/download-file']) ?>">
                                            <i class="fa-solid fa-file-import"></i>
                                            <span><?= Yii::t("app" , "a46") ?></span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?= Url::to(['cabinet/connection']) ?>">
                                            <i class="fa-solid fa-file-import"></i>
                                            <span><?= Yii::t("app" , "a47") ?></span>
                                        </a>
                                    </li>

                                    <li>
                                        <?= Html::a('<i class="fa-solid fa-file-import"></i> <span>'.Yii::t("app" , "a41").'</span>', ['site/logout'], [
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </li>

                                <?php else: ?>
                                    <li>
                                        <a href="tel:+998788886666">
                                            <i class="fa-solid fa-phone"></i>
                                            <span><?= Yii::t("app" , "a2") ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Url::to(['site/login']) ?>">
                                            <i class="fa-solid fa-file-import"></i>
                                            <span><?= Yii::t("app" , "a4") ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="ik_sidebar_list">
                            <p><?= Yii::t("app" , "a5") ?></p>
                            <ul>
                                <li><a style="font-size: 14px;" href="https://www.instagram.com/tgfu_uz/?igshid=MzRlODBiNWFlZA%3D%3D"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://t.me/tgfu_uzb"><i class="fa-brands fa-telegram"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://www.facebook.com/tgfu.uz?mibextid=ZbWKwL"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://youtube.com/@tgfuofficial?si=teblBgMHa0fG-nus"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="connectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ikmodel aloqa_model">
                <div class="ikmodel_item">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modalBody">
                        <img src="/frontend/web/images/wh_logo.png" alt="">
                        <div class="ik_connection">
                            <h5><?= Yii::t("app" , "a6") ?></h5>
                            <ul>
                                <li><p><?= Yii::t("app" , "a7") ?></p></li>
                                <li>
                                    <a href="tel:+998771292929">+998 (77) 129-29-29</a>
                                </li>
                            </ul>

                            <ul>
                                <li><p><?= Yii::t("app" , "a8") ?></p></li>
                                <li>
                                    <a href="tel:+998555000250">+998 (55) 500-02-50</a>
                                </li>
                            </ul>

                            <ul>
                                <li><p><?= Yii::t("app" , "a9") ?></p></li>
                                <li>
                                    <a href="https://maps.app.goo.gl/1aK5espkYi5Hvjde8">
                                        <?= Yii::t("app" , "a10") ?>
                                    </a>
                                </li>
                            </ul>

                            <div class="modal_vector_img">
                                <img src="/frontend/web/images/logo-vector.svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>