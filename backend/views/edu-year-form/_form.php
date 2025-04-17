<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\EduYear;
use common\models\EduForm;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\EduYearForm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-year-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?php $items = ArrayHelper::map(EduYear::find()->all(), 'id', 'name'); ?>
                        <?= $form->field($model, 'edu_year_id')->dropDownList(
                            $items,
                            ['prompt'=>'Yilni tanlang!']
                        ); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?php $items = ArrayHelper::map(EduForm::find()->all(), 'id', 'name_uz'); ?>
                        <?= $form->field($model, 'edu_form_id')->dropDownList(
                            $items,
                            ['prompt'=>'Edu formni tanlang!']
                        ); ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->dropDownList(
                            Status::accessStatus(),
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

</div>
