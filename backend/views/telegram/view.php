<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\TelegramOferta;
use common\models\TelegramDtm;
use common\models\TelegramPerevot;

/** @var yii\web\View $this */
/** @var common\models\Telegram $model */
/** @var \common\models\Direction $direction */

$direction = $model->direction;

$this->title = $model->chat_id;
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Botdan kelgan arizalar'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="telegram-view">

    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <div class="page-item mb-2">

        <div class="page_title mt-5">
            <h6 class="title-h5">Botdan kelgan ariz ma'lumotlari</h6>
            <div class="user-profil mb-3">
                <div class="dropdown">
                    <button class="dropdown-toggle d-flex align-items-center edite_drop" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user_title">
                            <h6>Tahrirlash</h6>
                        </div>
                    </button>
                    <ul class="drop_m dropdown-menu dropdown-menu-end" style="">
                        <ul class="drop_m_ul">
                            <li>
                                <?= Html::a("<span>Tasdiqlash</span><i class='fa-solid fa-user'></i>", ['confirm', 'id' => $model->id]) ?>
                            </li>
                            <li>
                                <?= Html::a("<span>Bekor qilish</span><i class='fa-solid fa-user'></i>", ['delete-canel', 'id' => $model->id]) ?>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'chat_id',
                [
                    'attribute' => 'step',
                    'contentOptions' => ['date-label' => 'step'],
                    'format' => 'raw',
                    'value' => function($model) {
                        return "<div class='badge-table-div active'><span>". $model->step ." - qadam</span></div>";
                    },
                ],
                'first_name',
                'last_name',
                'middle_name',
                'phone',
                'passport_serial',
                'passport_number',
                'passport_pin',
                'birthday',
                'passport_issued_date',
                'passport_given_date',
                'passport_given_by',
                'bot_status',
            ],
        ]) ?>
    </div>

    <div class="page-item mb-4">

        <div class="page_title mt-5">
            <h6 class="title-h5">Yo'nalish ma'lumotlari</h6>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-section">
                    <div class="form-section_item">
                        <?php if ($direction): ?>
                            <div class="row">

                                <div class="col-md-3 col-12">
                                    <div class="view-info-right">
                                        <p>Yo'nalish nomi</p>
                                        <h6><?= $direction->code.' - '.$direction->name_uz ?></h6>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="view-info-right">
                                        <p>Ta'lim tili</p>
                                        <h6><?= $direction->language->name_uz ?></h6>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="view-info-right">
                                        <p>Ta'lim shakli</p>
                                        <h6><?= $direction->eduForm->name_uz ?></h6>
                                    </div>
                                </div>

                                <?php if ($direction->edu_type_id == 1) : ?>

                                    <div class="col-md-3 col-12">
                                        <div class="view-info-right">
                                            <p>Imtixon turi</p>
                                            <h6>
                                                <?php if ($model->exam_type == 0) : ?>
                                                    Online
                                                <?php elseif ($model->exam_type == 1): ?>
                                                    Offline
                                                <?php endif; ?>
                                            </h6>
                                        </div>
                                    </div>

                                <?php endif; ?>

                            </div>
                        <?php else: ?>
                            <p align="center" class="svg_icon">
                                <svg  viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(24 31.67)"><ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse><path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path><path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path><path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path><path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path></g><path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path><g transform="translate(149.65 15.383)" fill="#FFF"><ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse><path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path></g></g></svg>
                            </p>
                            <br>
                            <p align="center">Yo'nalish tanlamagan ma'lumotlari mavjud emas.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($direction) : ?>
        <?php if ($direction->edu_type_id == 2) : ?>

            <?php $perevot = TelegramPerevot::findOne(['telegram_id' => $model->id]); ?>
            <div class="page-item mb-4">
                <div class="page_title mt-5 mb-3">
                    <h6 class="title-h5">Transkript ma'lumoti</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-section">
                            <div class="form-section_item">
                                <?php if ($perevot) : ?>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="view-info-right">
                                                <p>Holati</p>
                                                <h6>
                                                    <?php if ($perevot->file_status == 1) : ?>
                                                        <a target="_blank" href="/frontend/web/<?= $perevot->file ?>">Yuborilgan Transkript faylni ko'rish uchun bosing!</a>
                                                    <?php else: ?>
                                                        Yuborilmagan
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p align="center" class="svg_icon">
                                        <svg  viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(24 31.67)"><ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse><path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path><path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path><path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path><path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path></g><path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path><g transform="translate(149.65 15.383)" fill="#FFF"><ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse><path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path></g></g></svg>
                                    </p>
                                    <br>
                                    <p align="center">Transkript yuklash qismiga yetib kelmagan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($direction->edu_type_id == 3): ?>

            <?php $dtm = TelegramDtm::findOne(['telegram_id' => $model->id]); ?>
            <div class="page-item mb-4">
                <div class="page_title mt-5 mb-3">
                    <h6 class="title-h5">DTM ma'lumoti</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-section">
                            <div class="form-section_item">
                                <?php if ($dtm) : ?>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="view-info-right">
                                                <p>Holati</p>
                                                <h6>
                                                    <?php if ($dtm->file_status == 1) : ?>
                                                        <a target="_blank" href="/frontend/web/<?= $dtm->file ?>">Yuborilgan DTM faylni ko'rish uchun bosing!</a>
                                                    <?php else: ?>
                                                        Yuborilmagan
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p align="center" class="svg_icon">
                                        <svg  viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(24 31.67)"><ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse><path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path><path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path><path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path><path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path></g><path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path><g transform="translate(149.65 15.383)" fill="#FFF"><ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse><path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path></g></g></svg>
                                    </p>
                                    <br>
                                    <p align="center">DTM yuklash qismiga yetib kelmagan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($direction->oferta == 1) : ?>
            <?php $oferta = TelegramOferta::findOne(['telegram_id' => $model->id]); ?>
            <div class="page-item mb-4">
                <div class="page_title mt-5 mb-3">
                    <h6 class="title-h5">Oferta ma'lumoti</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-section">
                            <div class="form-section_item">
                                <?php if ($oferta) : ?>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="view-info-right">
                                                <p>Holati</p>
                                                <h6>
                                                    <?php if ($oferta->file_status == 1) : ?>
                                                        <a target="_blank" href="/frontend/web/<?= $oferta->file ?>">Yuborilgan oferta faylni ko'rish uchun bosing!</a>
                                                    <?php else: ?>
                                                        Yuborilmagan
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p align="center" class="svg_icon">
                                        <svg  viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(24 31.67)"><ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse><path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path><path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path><path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path><path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path></g><path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path><g transform="translate(149.65 15.383)" fill="#FFF"><ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse><path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path></g></g></svg>
                                    </p>
                                    <br>
                                    <p align="center">Oferta yuklash qismiga yetib kelmagan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
