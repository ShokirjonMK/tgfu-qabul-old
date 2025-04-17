<?php
use common\models\EduYearForm;
use common\models\Direction;
use common\models\Languages;
use yii\helpers\Url;

$eduYearForms = EduYearForm::find()
    ->where(['is_deleted' => 0, 'status' => 1])
    ->all();
$lang = Yii::$app->language;
?>



<div class="ik_content" id="ik_direc">
    <div class="ik_content_box">
        <div class="ik_content_direction">
            <div class="root-item">
                <div class="ik_title_box">
                    <div class="ik_main_title" data-aos="fade-up" data-aos-duration="2000">
                        <p><?= Yii::t("app" , "a12") ?></p>
                        <h4><?= Yii::t("app" , "a13") ?></h4>
                    </div>
                </div>

                <div class="ik_nav_pills">
                    <div class="ik_nav_pills_item">
                        <ul class="nav nav-pills mb-4 view-tabs" id="pills-tab" role="tablist" data-aos="fade-up" data-aos-duration="2000">
                            <?php $a = 1 ?>
                            <?php foreach ($eduYearForms as $eduYearForm) : ?>
                                <?php
                                $directionCount = (new \yii\db\Query())
                                    ->select('code')
                                    ->from('direction')
                                    ->where(['status' => 1, 'is_deleted' => 0, 'edu_year_form_id' => $eduYearForm->id])
                                    ->groupBy('code')
                                    ->count();
                                ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php if ($a == 1) { echo "active";} ?>" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills_ik<?= $a ?>" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                                        <?= $eduYearForm->eduForm['name_'.$lang] ?> <?= Yii::t("app" , "a14") ?> &nbsp;&nbsp; <span class="btn-span"><?= $directionCount ?></span>
                                    </button>
                                </li>
                                <?php $a++; ?>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content" id="pills-tabContent" data-aos="fade-up" data-aos-duration="2000">
                            <?php $a = 1 ?>
                            <?php foreach ($eduYearForms as $eduYearForm) : ?>
                                <?php
                                $eduForm = $eduYearForm->eduForm;
                                $subQuery = (new \yii\db\Query())
                                    ->select(['MAX(id)'])
                                    ->from('direction')
                                    ->where([
                                        'status' => 1,
                                        'is_deleted' => 0,
                                        'edu_year_form_id' => $eduYearForm->id
                                    ])->groupBy('code');

                                $directions = Direction::find()
                                    ->where(['id' => $subQuery])
                                    ->all();
                                ?>
                                <div class="tab-pane fade <?php if ($a == 1) { echo "show active";} ?>" id="pills_ik<?= $a ?>" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <?php if (count($directions) > 0) : ?>
                                        <div class="grid-view">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th><?= Yii::t("app" , "a15") ?></th>
                                                    <th><?= Yii::t("app" , "a16") ?></th>
                                                    <th><?= Yii::t("app" , "a17") ?></th>
                                                    <th><?= Yii::t("app" , "a18") ?></th>
                                                    <th><?= Yii::t("app" , "a19") ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $t = 1; ?>
                                                    <?php foreach ($directions as $direction) : ?>
                                                        <?php
                                                            $languages = Languages::find()
                                                                ->where(['in' , 'id' , Direction::find()
                                                                    ->select('language_id')
                                                                    ->where([
                                                                        'code' => $direction->code,
                                                                        'edu_year_form_id' => $eduYearForm->id,
                                                                        'status' => 1,
                                                                        'is_deleted' => 0
                                                                    ])
                                                                ])->all();
                                                        ?>
                                                        <tr>
                                                            <td date-label="№"><?= $t ?></td>
                                                            <td date-label="<?= Yii::t("app" , "a15") ?>"><?= '<span class="ik_color_red">'.$direction->code.'</span>'.' - '.$direction['name_'.$lang] ?></td>
                                                            <td date-label="<?= Yii::t("app" , "a16") ?>"><?= $eduForm['name_'.$lang]; ?></td>
                                                            <td date-label="<?= Yii::t("app" , "a17") ?>">
                                                                <?php if (count($languages) > 0): ?>
                                                                    <span class="ik_lang_table">
                                                                        <?php foreach ($languages as $language): ?>
                                                                             <span><?= $language['name_'.$lang] ?></span>
                                                                        <?php endforeach; ?>
                                                                    </span>
                                                                <?php else: ?>
                                                                    -----
                                                                <?php endif; ?>
                                                            </td>
                                                            <td date-label="<?= Yii::t("app" , "a18") ?>"><?= $direction->edu_duration ?> &nbsp; <?= Yii::t("app" , "a20") ?></td>
                                                            <td date-label="<?= Yii::t("app" , "a19") ?>"><?= number_format((int)$direction->contract, 0, '', ' '); ?> <?= Yii::t("app" , "a21") ?></td>
                                                        </tr>
                                                        <?php $t++; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </div>
                                <?php $a++; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ik_footer">
    <div class="root-item">
        <div class="ik_footer_box">
            <div class="mb_head d-flex justify-content-center">
                <div class="mb_hd_ik_logo" data-aos="fade-up" data-aos-duration="2000">
                    <a href="<?= Url::to(['site/index']) ?>">
                        <img src="/frontend/web/images/tgfu-logo-login_text.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="ik_mb_footer">
                <div class="mb_menu_list2">
                    <ul>
                        <li>
                            <a href="https://t.me/globalsoftline">
                                <span><?= Yii::t("app" , "a22") ?> <b>GLOBAL SOFTLINE GROUP</b></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>