<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DirectionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="direction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_uz') ?>

    <?= $form->field($model, 'name_ru') ?>

    <?= $form->field($model, 'name_en') ?>

    <?= $form->field($model, 'edu_year_id') ?>

    <?php // echo $form->field($model, 'language_id') ?>

    <?php // echo $form->field($model, 'edu_year_type_id') ?>

    <?php // echo $form->field($model, 'edu_year_form_id') ?>

    <?php // echo $form->field($model, 'edu_form_id') ?>

    <?php // echo $form->field($model, 'edu_type_id') ?>

    <?php // echo $form->field($model, 'contract') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'course_json') ?>

    <?php // echo $form->field($model, 'oferta') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
