<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Telegram $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telegram-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'chat_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'step')->textInput() ?>

    <?= $form->field($model, 'lang_id')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_pin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_issued_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_given_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_given_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edu_year_type_id')->textInput() ?>

    <?= $form->field($model, 'edu_year_form_id')->textInput() ?>

    <?= $form->field($model, 'direction_id')->textInput() ?>

    <?= $form->field($model, 'language_id')->textInput() ?>

    <?= $form->field($model, 'direction_course_id')->textInput() ?>

    <?= $form->field($model, 'exam_type')->textInput() ?>

    <?= $form->field($model, 'edu_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edu_direction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
