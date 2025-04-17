<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Exam $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'direction_id')->textInput() ?>

    <?= $form->field($model, 'language_id')->textInput() ?>

    <?= $form->field($model, 'edu_year_form_id')->textInput() ?>

    <?= $form->field($model, 'edu_year_type_id')->textInput() ?>

    <?= $form->field($model, 'edu_type_id')->textInput() ?>

    <?= $form->field($model, 'edu_form_id')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'finish_time')->textInput() ?>

    <?= $form->field($model, 'ball')->textInput() ?>

    <?= $form->field($model, 'exam_count')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <?= $form->field($model, 'contract_type')->textInput() ?>

    <?= $form->field($model, 'contract_price')->textInput() ?>

    <?= $form->field($model, 'contract_second')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contract_third')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contract_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'down_time')->textInput() ?>

    <?= $form->field($model, 'correct_type')->textInput() ?>

    <?= $form->field($model, 'confirm_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
