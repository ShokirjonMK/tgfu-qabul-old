<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;
use common\models\ExamSubject;

/** @var yii\web\View $this */
/** @var common\models\ExamSubject $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="check-exam-form">

    <div class="col-12 mb-3">
        <div class="border-bottom"></div>
        <div class="row mt-4 modal-left-right">
            <div class="col-6 d-flex align-items-start flex-column">
                <p>Fan nomi:</p>
                <h6><?= $model->subject->name_uz; ?></h6>
            </div>
            <div class="col-6 d-flex align-items-end flex-column">
                <p>Jami savollar soni:</p>
                <h6><?= $model->directionSubject->question_count ?> ta</h6>
            </div>
        </div>
        <div class="row mt-4 modal-left-right">
            <div class="col-6 d-flex align-items-start flex-column">
                <p>Bitta savolga beriladigan ball:</p>
                <h6><?= $model->directionSubject->ball; ?> ball</h6>
            </div>
            <div class="col-6 d-flex align-items-end flex-column">
                <p>Maksimal ball:</p>
                <h6><?= $model->directionSubject->ball * $model->directionSubject->question_count ?> ball</h6>
            </div>
        </div>
    </div>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_status')->widget(Select2::classname(), [
        'data' => Status::perStatus(),
        'options' => ['placeholder' => 'Status tanlang ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group mt-2">
        <?= $form->field($model, 'sms_text')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group d-flex justify-content-end mt-3">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
$(document).ready(function() {
        $(".check-exam-form #examsubject-file_status").on('change', function () {
            var id = $(this).val();
            var text2 = 'Tabriklaymiz! Sizning “TOSHKENT GUMANITAR FANLAR UNIVERSITETI”ga topshirgan  sertifikatingiz tasdiqlandi va sizga fan blokidan maksimal ball berildi. To\'lov shartnomasini yuklab olishni unutmang. Shartnomangizni https://qabul.tgfu.uz sayti orqali yuklab oling. Aloqa markazi: 78 888 66 66';
            var text3 = 'Hurmatli abituriyent! Sizning “TOSHKENT GUMANITAR FANLAR UNIVERSITETI”ga topshirgan  sertifikatingiz rad etildi. Online test topshirib to\'lov shartnomasini yuklab olishni unutmang. Shartnomangizni https://qabul.tgfu.uz sayti orqali yuklab oling. Aloqa markazi: 78 888 66 66';
            if (id == 3) {
                $(".check-exam-form #examsubject-sms_text").val(text3)
            } else {
                if (id == 2) {
                    $(".check-exam-form #examsubject-sms_text").val(text2)
                } else {
                    $(".check-exam-form #examsubject-sms_text").val('')
                }
            }
            
        });
    });
JS;
$this->registerJs($js);
?>
