<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\Employee $model */

$this->title = Yii::t('app', 'Administrator ma\'lumoti.');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Administratorlar'),
    'url' => ['index'],
];
$user = $model->user;
if ($model->image == null) {
    if ($model->gender == 1) {
        $imageUrl = "/backend/web/edu-assets/image/edu-smart-image/man.png";
    } else {
        $imageUrl = "/backend/web/edu-assets/image/edu-smart-image/woman.png";
    }
} else {
    $imageUrl = "/backend/web/uploads/employee/".$model->image;
}


\yii\web\YiiAsset::register($this);
?>
<div class="page">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <div class="page-buttons">
        <ul>
            <li>
                <?= Html::a(Yii::t('app', '<i class="fa-solid fa-pencil"></i>'), ['update', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', '<i class="fa-solid fa-trash"></i>'), ['delete', 'id' => $model->id], [
                    'class' => 'b-btn b-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </li>
        </ul>
    </div>


    <div class="page-item mb-4">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-section">
                    <div class="form-section_item">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-12 col-sm-12 col-12 right-border">
                                <div class="view-info-left">
                                    <div class="view-logo mb-4">
                                        <img src="<?= $imageUrl ?>" alt="">
                                    </div>
                                    <p class="name text-center"><?= $model->first_name." ".$model->last_name." ".$model->middle_name ?></p>
                                    <p class="name_bottom text-center"><?= $user->authItem->description ?></p>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>ID nomer.</p>
                                            <h6>№: <?= $user->id ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Tizimga kirish ( username ).</p>
                                            <h6><?= $user->username ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Tizimga kirish ( parol ). <i id="passwordView" class="fas fa-eye-slash"></i></p>
                                            <h6 class="textPassword"><?= $model->password ?></h6>
                                            <h6 class="slashPassword">********</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row view-mt">
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Holati.</p>
                                            <h6>
                                                <?php if ($user->status == 10): ?>
                                                    Aktiv
                                                <?php endif; ?>
                                                <?php if ($user->status == 9): ?>
                                                    Aktiv emas
                                                <?php endif; ?>
                                                <?php if ($user->status == 0): ?>
                                                    Bloklangan
                                                <?php endif; ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Tug'ilgan yili.</p>
                                            <h6><?= $model->brithday ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Jinsi.</p>
                                            <h6>
                                                <?php
                                                if ($model->gender == 1) {
                                                    echo "Erkak";
                                                } else {
                                                    echo "Ayol";
                                                }
                                                ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row view-mt">
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Oylik turi.</p>
                                            <h6>
                                                <?php
                                                $result = Status::employeePaymentType($model->payment_type);
                                                echo $result['name'];
                                                ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>
                                                <?php if ($model->payment_type == 0) : ?>
                                                    Oylik miqdori
                                                <?php else: ?>
                                                    Foiz miqdori
                                                <?php endif; ?>
                                            </p>
                                            <h6>
                                                <?php if ($model->payment_type == 0) : ?>
                                                    <?= number_format($model->payment_cost  ,2,'.',' ') ?>
                                                <?php else: ?>
                                                    <?= $model->payment_cost." %"; ?>
                                                <?php endif; ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Manzil.</p>
                                            <h6><?= $model->adress ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-item mb-4">
        <div class="form-section">
            <div class="form-section_item">
                <ul class="nav nav-pills mb-3 view-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">O'quv markazlari</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Oylik hisobot</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <p align="center">
                            <svg width="150" height="122" viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(24 31.67)"><ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse><path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path><path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path><path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path><path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path></g><path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path><g transform="translate(149.65 15.383)" fill="#FFF"><ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse><path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path></g></g></svg>
                        </p>
                        <p align="center">Ma'lumot mavjud emas.</p>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">...</div>
                </div>
            </div>
        </div>
    </div>

</div>
