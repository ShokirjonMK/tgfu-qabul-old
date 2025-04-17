<?php
use yii\helpers\Url;
?>

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
                                    <a href="tel:+998978638888" data-bs-toggle="modal" data-bs-target="#connectionModal">
                                        <i class="fa-solid fa-phone"></i>
                                        <span><?= Yii::t("app" , "a2") ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#ik_direc">
                                        <i class="fa-solid fa-sitemap"></i>
                                        <span><?= Yii::t("app" , "a3") ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['site/login']) ?>">
                                        <i class="fa-solid fa-file-import"></i>
                                        <span><?= Yii::t("app" , "a4") ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="ik_sidebar_list">
                            <p><?= Yii::t("app" , "a5") ?></p>
                            <ul>
                                <li><a style="font-size: 14px;" href="https://www.instagram.com/perfect.university?igsh=ODhqOWJpMnM0YTFk"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://t.me/perfect_university"><i class="fa-brands fa-telegram"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://www.facebook.com/perfectuniversity.uz?mibextid=kFxxJD"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a style="font-size: 14px;" href="https://youtube.com/@perfectuniversity4471?si=1hvUQR7t5bATWlcI"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>