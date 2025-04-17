<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use common\models\Student;
use kartik\select2\Select2;
use common\models\Status;

/** @var $model */
/** @var Student $student */
/** @var $id */

$model->password = $student->password;
$model->status = $student->user->status;
?>


<div class="step_one_box">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'password')->textInput()->label('Parol <span>*</span>'); ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => Status::userStatusUpdate(),
            'options' => ['placeholder' => 'Status tanlang ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Status tanlang <span>*</span>'); ?>
    </div>


    <div class="d-flex justify-content-center mt-2 mb-2">
        <?= Html::submitButton('Ma\'lumotni saqlash', ['class' => 'b-btn b-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>





