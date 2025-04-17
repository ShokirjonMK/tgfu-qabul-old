<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TelegramPerevot $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telegram-perevot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'telegram_id')->textInput() ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
