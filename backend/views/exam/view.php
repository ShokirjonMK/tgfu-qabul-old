<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\Exam $model */
/** @var common\models\ExamSubject $examSubjects */

$this->title = 'Arizani to\'liq ma\'lumoti';
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Qabul'),
    'url' => ['index'],
];
$student = $model->student;
$full_name = $student->last_name.' '.$student->first_name.' '.$student->middle_name;
$direction = $model->direction;
$examSubjects = $model->examSubjects;
$status = '';
if ($model->status == 0) {
    $status = 'Bekor qilingan';
} elseif ($model->status == 1) {
    $status = 'Testga kirmagan';
} elseif ($model->status == 2) {
    $status = 'Testda';
} elseif ($model->status == 3) {
    $status = 'Testni yakunlagan';
}

\yii\web\YiiAsset::register($this);
?>
<div class="exam-view">

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

    <div class="page-item mb-4">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-section">
                    <div class="form-section_item">
                        <div class="row">

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>F.I.O</p>
                                    <h6><?= $full_name ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>Pasport ma'lumoti</p>
                                    <h6><?= $student->passport_serial.' '.$student->passport_number ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>JShR</p>
                                    <h6><?= $student->passport_pin ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>Tug'ilgan sana</p>
                                    <h6><?= $student->birthday ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>Telefon raqam</p>
                                    <h6><?= $student->user->username ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>Parol</p>
                                    <h6><?= $student->password ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="view-info-right">
                                    <p>Yo'nalish</p>
                                    <h6><?= $direction->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-4">
                                <div class="view-info-right">
                                    <p>Yo'nalish kodi</p>
                                    <h6><?= $direction->code ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2 mb-4">
                                <div class="view-info-right">
                                    <p>Ta'lim shakli</p>
                                    <h6><?= $direction->eduForm->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2">
                                <div class="view-info-right">
                                    <p>Ta'lim turi</p>
                                    <h6><?= $direction->eduType->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2">
                                <div class="view-info-right">
                                    <p>Ta'lim tili</p>
                                    <h6><?= $direction->language->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2">
                                <div class="view-info-right">
                                    <p>Holati</p>
                                    <h6>
                                        <?= $status ?>
                                    </h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php if (count($examSubjects) > 0) : ?>
        <?php foreach ($examSubjects as $examSubject) : ?>
            <p class="mb-3 d-flex justify-content-end gap-2">
                <?= Html::a(Yii::t('app', 'Sertifikat yuklash'), ['upload', 'id' => $examSubject->id],
                    [
                        'class' => 'b-btn b-primary',
                        "data-bs-toggle" => "modal",
                        "data-bs-target" => "#studentSerUpload",
                    ])
                ?>
                <?= Html::a(Yii::t('app', 'Sertifikat tasdiqlash'), ['confirm', 'id' => $examSubject->id],
                    [
                        'class' => 'b-btn b-primary',
                        "data-bs-toggle" => "modal",
                        "data-bs-target" => "#studentSerConfirm",
                    ]) ?>
            </p>
            <div class="page-item mb-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-section">
                            <div class="form-section_item">
                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Fan nomi:</p>
                                            <h6><?= $examSubject->subject->name_uz ?></h6>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <p>Ball</p>
                                            <h6><?= $examSubject->ball ?> ball</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="view-info-right">
                                            <?php
                                            $file_status = '';
                                            if ($examSubject->file_status == 0) {
                                                $file_status = 'Fayl yuklanmagan';
                                            } elseif ($examSubject->file_status == 1) {
                                                $file_status = 'Tasdiqni kutmoqda';
                                            } elseif ($examSubject->file_status == 2) {
                                                $file_status = 'Tasdiqlandi';
                                            } elseif ($examSubject->file_status == 3) {
                                                $file_status = 'Bekor qilindi';
                                            }
                                            ?>
                                            <p>Sertifikat ( <?= $file_status ?> )</p>
                                            <?php if ($examSubject->file_status == 0) : ?>
                                                <h6>Fayl yuklanmagan</h6>
                                            <?php else: ?>
                                                <h6><a target="_blank" href="/frontend/web/uploads/<?= $model->student_id ?>/<?= $examSubject->file ?>">Faylni ko'rish uchun bosing</a></h6>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if ($model->status == 3) : ?>
        <div class="page-item mb-4">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-section">
                        <div class="form-section_item">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="view-info-right">
                                        <p>Ikki tomonlama shartnoma</p>
                                        <h6><a href="<?= Url::to(['contract/index' , 'id' => $model->student_id , 'type' => 2]) ?>">Yuklash uchun bosing</a></h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="view-info-right">
                                        <p>Uch tomonlama shartnoma</p>
                                        <h6>
                                            <h6><a href="<?= Url::to(['contract/index' , 'id' => $model->student_id , 'type' => 3]) ?>">Yuklash uchun bosing</a></h6>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="modal fade" id="studentSerUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="form-section">
                    <div class="form-section_item">
                        <div class="modal-header">
                            <h1 class="modal-title" id="exampleModalLabel">Sertifikat yuklang</h1>
                            <p class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>
                        </div>
                        <div class="modal-body" id="studentSerUploadBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="studentSerConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="form-section">
                <div class="form-section_item">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Sertifikatni tasdiqlash</h1>
                        <p class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>
                    </div>
                    <div class="modal-body" id="studentSerConfirmBody">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    $('#studentSerUpload').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerUploadBody').load(url);
    });
    
    $('#studentSerConfirm').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerConfirmBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>
