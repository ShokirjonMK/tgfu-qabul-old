<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;
use common\models\StudentOferta;

/** @var yii\web\View $this */
/** @var common\models\StudentOferta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="check-exam-form">

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
        $(".check-exam-form #studentoferta-file_status").on('change', function () {
            var id = $(this).val();
            var text2 = 'Tabriklaymiz!';
            var text3 = 'Hurmatli abituriyent!';
            if (id == 3) {
                $(".check-exam-form #studentoferta-sms_text").val(text3)
            } else {
                if (id == 2) {
                    $(".check-exam-form #studentoferta-sms_text").val(text2)
                } else {
                    $(".check-exam-form #studentoferta-sms_text").val('')
                }
            }
            
        });
    });
JS;
$this->registerJs($js);
?>
