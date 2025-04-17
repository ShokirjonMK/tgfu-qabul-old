<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Employee $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="page">

    <!--   Form   -->
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'gender')->dropDownList(
                            Status::gender(),
                            ['class'=>'form-select form-control']) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'phone', [
                        ])->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => '+\9\9\8 (99) 999-99-99',
                        ])?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'brithday')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter birth date ...'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'payment_type')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Status::employeePaymentType(), 'id', 'name'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'payment_cost')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'adress')->textarea(['rows' => 3]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->render('/layouts/_upload');?>
                        <div class="form-group">
                            <?= $form->field($model, 'avatar')->fileInput(['id'=>'upload','hidden'=>'hidden','class'=>'click_file'])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-section mt-4">
        <div class="form-section_item">
            <h6>Tizimga kirish ma'lumotlari.</h6>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'password' , ['template' => "{label} \n {input} \n {error} \n <i id='clickPassword' class='fas fa-eye-slash eyeSlashPassword'></i>"])->passwordInput(['id'=>'eye_password','maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->dropDownList(
                            Status::organAccessStatus(),
                            ['class'=>'form-select form-control']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group d-flex justify-content-end mt-4 mb-5">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'b-btn b-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <!--   Form   -->


</div>
