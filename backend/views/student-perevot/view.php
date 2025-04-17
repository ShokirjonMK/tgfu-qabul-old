<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Course;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevot $model */

$this->title = $model->id;
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'O\'qishni ko\'chirish'),
    'url' => ['index'],
];
$student = $model->student;
$full_name = $student->last_name.' '.$student->first_name.' '.$student->middle_name;
$direction = $model->direction;
$text = '';
if ($model->file_status == 0) {
    $text = 'Fayl yo\'q';
} elseif ($model->file_status == 1) {
    $text = 'Kelib tushgan';
} elseif ($model->file_status == 2) {
    $text = 'Tasdiqlandi';
} elseif ($model->file_status == 3) {
    $text = 'Bekor qilindi';
}
\yii\web\YiiAsset::register($this);
?>
<div class="student-perevot-view">

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

                            <div class="col-md-4 col-12 mb-4">
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

                            <div class="col-md-4 col-12 mt-2  mb-4">
                                <div class="view-info-right">
                                    <p>Ta'lim shakli</p>
                                    <h6><?= $direction->eduForm->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2  mb-4">
                                <div class="view-info-right">
                                    <p>Ta'lim turi</p>
                                    <h6><?= $direction->eduType->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2  mb-4">
                                <div class="view-info-right">
                                    <p>Ta'lim tili</p>
                                    <h6><?= $direction->language->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2 mb-4">
                                <div class="view-info-right">
                                    <p>Avvalgi o'qigan OTM</p>
                                    <h6><?= $student->edu_name ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2 mb-4">
                                <div class="view-info-right">
                                    <p>Avvalgi o'qigan yo'nalishi</p>
                                    <h6><?= $student->edu_direction ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2 mb-4">
                                <div class="view-info-right">
                                    <p>Qabul qilinadigan bosqich</p>
                                    <?php
                                    $courseId = $student->course_id + 1;
                                    $course = Course::findOne($courseId)
                                    ?>
                                    <h6><?= $course->name_uz ?></h6>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 mt-2">
                                <div class="view-info-right">
                                    <p>Holati</p>
                                    <h6>
                                        <?php if ($model->status == 1 && $model->is_deleted == 0) : ?>
                                            Faol
                                        <?php else: ?>
                                            Bekor qiligan
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php if ($model->status == 1 && $model->is_deleted == 0) : ?>
        <p class="mb-3 d-flex justify-content-end gap-2">
            <?= Html::a(Yii::t('app', 'Arizani tasdiqlash'),
                ['check', 'id' => $model->id],
                [
                    'class' => 'b-btn b-primary',
                    "data-bs-toggle" => "modal",
                    "data-bs-target" => "#studentTrCreate",
                ]) ?>
        </p>
    <?php endif; ?>


        <div class="page-item mb-4">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-section">
                        <div class="form-section_item">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="view-info-right">
                                        <p>Ariza holati</p>
                                        <h6><?= $text ?></h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="view-info-right">
                                        <p>Ariza fayl</p>
                                        <h6>
                                            <a href="/frontend/web/uploads/<?= $model->student_id ?>/<?= $model->file ?>" target="_blank">
                                                Ko'rish uchun bosing
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($model->file_status == 2) : ?>
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

        <div class="modal fade" id="studentTrCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="form-section">
                        <div class="form-section_item">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel">Ariza holatini belgilang</h1>
                                <p class="btn-close" data-bs-dismiss="modal" aria-label="Close"></p>
                            </div>
                            <div class="modal-body" id="studentTrCreateBody">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    $('#studentTrCreate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentTrCreateBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>

