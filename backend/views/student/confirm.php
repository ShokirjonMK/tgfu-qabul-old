<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \backend\models\AddBall $model */
/** @var \common\models\ExamSubject $examSubject */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="check-exam-form">

    <div class="col-12 mb-3">
        <div class="border-bottom"></div>
        <div class="row mt-4 modal-left-right">
            <div class="col-6 d-flex align-items-start flex-column">
                <p>Fan nomi:</p>
                <h6><?= $examSubject->subject->name_uz; ?></h6>
            </div>
            <div class="col-6 d-flex align-items-end flex-column">
                <p>Jami savollar soni:</p>
                <h6><?= $examSubject->directionSubject->question_count ?> ta</h6>
            </div>
        </div>
        <div class="row mt-4 modal-left-right">
            <div class="col-6 d-flex align-items-start flex-column">
                <p>Bitta savolga beriladigan ball:</p>
                <h6><?= $examSubject->directionSubject->ball; ?> ball</h6>
            </div>
            <div class="col-6 d-flex align-items-end flex-column">
                <p>Maksimal ball:</p>
                <h6><?= $examSubject->directionSubject->ball * $examSubject->directionSubject->question_count ?> ball</h6>
            </div>
        </div>
    </div>


    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group mt-2">
        <?= $form->field($model, 'confirm_question_count')->textInput()->label('Tog\'ri javoblar sonini kiriting!') ?>
    </div>

    <div class="form-group d-flex justify-content-end mt-3">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
