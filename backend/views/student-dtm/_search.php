<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StudentDtmSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-dtm-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'direction_id') ?>

    <?= $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'file_status') ?>

    <?php // echo $form->field($model, 'contract_type') ?>

    <?php // echo $form->field($model, 'contract_price') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'contract_second') ?>

    <?php // echo $form->field($model, 'contract_third') ?>

    <?php // echo $form->field($model, 'contract_link') ?>

    <?php // echo $form->field($model, 'down_time') ?>

    <?php // echo $form->field($model, 'confirm_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
