<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Status;
use common\models\Course;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\DirectionCourse $model */
/** @var yii\widgets\ActiveForm $form */
$courses = Course::find()->where(['status' => 1, 'is_deleted' => 0])->all();
?>

<div class="direction-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'course_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($courses, 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
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
