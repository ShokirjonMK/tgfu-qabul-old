<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \backend\models\SendSms $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="check-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'text')->textarea(['rows' => 6])->label('Sms matnini kiriting') ?>
    </div>

    <div class="form-group d-flex justify-content-center mt-3">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
