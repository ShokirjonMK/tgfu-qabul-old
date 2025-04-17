<?php
use common\models\Student;
use common\models\Filial;

$this->title = Yii::t("app" , "a104");
$user = Yii::$app->user->identity;
$student = Student::findOne(['user_id' => $user->id]);
$filial = Filial::findOne(['id' => $student->filial_id]);
if (!$filial) {
    $filial = Filial::find()->where(['is_deleted' => 0])->orderBy('id asc')->one();
}
?>

<div class="down_box top30">
    <div class="down_title">
        <h6><i class="fa-brands fa-slack"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a104") ?></h6>
    </div>

    <div class="down_content">
        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="tel:<?= preg_replace('/[\s\(\)\-]/', '', $filial->phone ) ?>" class="down_content_box">
                    <div class="down_content_box_left">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div class="down_content_box_right">
                        <p><?= Yii::t("app" , "a105") ?></p>
                        <h6><?= $filial->phone ?></h6>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?= $filial->address_link ?>" target="_blank" class="down_content_box">
                    <div class="down_content_box_left">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="down_content_box_right">
                        <p><?= Yii::t("app" , "a9") ?></p>
                        <h6><?= $filial->address_uz ?></h6>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="https://www.instagram.com/tgfu_uz/?igshid=MzRlODBiNWFlZA%3D%3D" target="_blank" class="down_content_box">
                    <div class="down_content_box_left">
                        <img src="/frontend/web/images/instagram.svg" alt="">
                    </div>
                    <div class="down_content_box_right">
                        <p>Instagram</p>
                        <h6><?= Yii::t("app" , "a108") ?></h6>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="https://www.facebook.com/tgfu.uz?mibextid=ZbWKwL" target="_blank" class="down_content_box">
                    <div class="down_content_box_left">
                        <img src="/frontend/web/images/facebook.svg" alt="">
                    </div>
                    <div class="down_content_box_right">
                        <p>Facebook</p>
                        <h6><?= Yii::t("app" , "a108") ?></h6>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="https://t.me/tgfu_uzb" target="_blank" class="down_content_box">
                    <div class="down_content_box_left">
                        <img src="/frontend/web/images/telegram.svg" alt="">
                    </div>
                    <div class="down_content_box_right">
                        <p>Telegram</p>
                        <h6><?= Yii::t("app" , "a108") ?></h6>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="https://youtube.com/@tgfuofficial?si=teblBgMHa0fG-nus" target="_blank" class="down_content_box">
                    <div class="down_content_box_left">
                        <img src="/frontend/web/images/youtube.svg" alt="">
                    </div>
                    <div class="down_content_box_right">
                        <p>YouTube</p>
                        <h6><?= Yii::t("app" , "a108") ?></h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
