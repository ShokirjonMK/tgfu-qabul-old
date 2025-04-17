<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Subjects;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\DirectionSubject $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\Direction $direction */

$subjects = Subjects::find()
    ->where(['language_id' => $direction->language_id , 'status' => 1, 'is_deleted' => 0])
    ->orderBy('id desc')
    ->all();
?>

<div class="direction-subject-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <?= $form->field($model, 'subject_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($subjects, 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'ball')->textInput() ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'question_count')->textInput() ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
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
