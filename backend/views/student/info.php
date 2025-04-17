<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use common\models\Student;

/** @var $model */
/** @var Student $student */
/** @var $id */

$model->birthday = $student->birthday;
$model->seria = $student->passport_serial;
$model->number = $student->passport_number;
?>


<div class="step_one_box">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Tug\'ilgan sanangizni kiriting ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('Tug\'ilgan sanangizni kiriting <span>*</span>'); ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'seria')->textInput([
            'maxlength' => true,
            'placeholder' => '__',
            'oninput' => "this.value = this.value.replace(/\\d/, '').toUpperCase()"
        ])->label('Pasportingiz seriyasi <span>*</span>') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'number')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '9999999',
            'options' => [
                'placeholder' => '_______',
            ],
        ])->label('Pasportingiz raqami <span>*</span>') ?>
    </div>

    <div class="d-flex justify-content-center mt-2 mb-2">
        <?= Html::submitButton('Ma\'lumotni saqlash', ['class' => 'b-btn b-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>





