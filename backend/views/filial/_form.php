<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Filial $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="filial-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'univer_name_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'address_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'address_link')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'h_r')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'bank_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'mfo')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'stir')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'oked')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'prorektor_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group d-flex justify-content-end mt-4 mb-5">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
