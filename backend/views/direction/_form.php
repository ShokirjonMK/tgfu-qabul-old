<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;
use common\models\Languages;
use yii\helpers\ArrayHelper;
use common\models\EduYearType;
use common\models\EduYearForm;

/** @var yii\web\View $this */
/** @var common\models\Direction $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\EduYear $eduYear */

$languages = Languages::find()->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduYearTypes = EduYearType::getEduTypeName($eduYear);
$eduYearForms = EduYearForm::getEduFormName($eduYear);
?>

<div class="direction-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'contract')->textInput() ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_duration')->textInput() ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'language_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($languages, 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_year_type_id')->widget(Select2::classname(), [
                            'data' => $eduYearTypes,
                            'options' => ['placeholder' => 'Oferta tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_year_form_id')->widget(Select2::classname(), [
                            'data' => $eduYearForms,
                            'options' => ['placeholder' => 'Oferta tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'oferta')->widget(Select2::classname(), [
                            'data' => Status::ofertaStatus(),
                            'options' => ['placeholder' => 'Oferta tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => Status::accessStatus(),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
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
