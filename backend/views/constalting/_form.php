<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Constalting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="constalting-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <?= $form->field($model, 'h_r')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group d-flex justify-content-end mt-4 mb-5">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
