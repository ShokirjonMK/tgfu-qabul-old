<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\Languages;
use common\models\EduYear;
use common\models\EduYearForm;
use common\models\Direction;
use common\models\Status;
use kartik\date\DatePicker;
use common\models\Filial;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevotSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\EduYearType $edu_type */

$languages = Languages::find()->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
$eduYearForms = EduYearForm::getEduFormName($eduYear);
$data = [];
$directions = Direction::find()
    ->where([
        'edu_year_type_id' => $edu_type->id,
        'edu_year_form_id' => $model->edu_year_form_id,
        'language_id' => $model->language_id,
        'status' => 1,
        'is_deleted' => 0
    ])->all();
if (count($directions) > 0) {
    foreach ($directions as $direction) {
        $data[$direction->id] = $direction->name_uz;
    }
}

$status = [];
if ($edu_type->edu_type_id == 1) {
    $status = Status::eStatus();
} elseif ($edu_type->edu_type_id > 1) {
    $status = Status::perStatus();
}

$filials = Filial::find()
    ->where(['is_deleted' => 0])
    ->all();


?>

<div class="student-perevot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index' , 'id' => $edu_type->id],
        'method' => 'get',
    ]); ?>

    <div class="form-section mb-4">
        <div class="form-section_item">

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'first_name') ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'last_name') ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'middle_name') ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'username')
                            ->widget(\yii\widgets\MaskedInput::class, [
                                'mask' => '+\9\9\8 (99) 999-99-99',
                                'options' => [
                                    'placeholder' => '+998 (__) ___-__-__',
                                ],
                            ]) ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'language_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($languages, 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Ta\'lim  tilini tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Ta\'lim tili <span>*</span>'); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'edu_year_form_id')->widget(Select2::classname(), [
                            'data' => $eduYearForms,
                            'options' => ['placeholder' => 'Ta\'lim shaklini tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Ta\'lim shakli <span>*</span>');; ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'direction_id')->widget(Select2::classname(), [
                            'data' => $data,
                            'options' => ['placeholder' => 'Yo\'nalish tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Ta\'lim Yo\'nalishi <span>*</span>');; ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => $status,
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Status <span>*</span>');; ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'filial_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($filials, 'id', 'name_uz'),
                            'options' => ['placeholder' => 'Filial tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Filial <span>*</span>'); ?>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Start date ...'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label('Start Date <span>*</span>'); ?>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'End date ...'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label('End Date <span>*</span>'); ?>
                    </div>
                </div>

                <?php if ($edu_type->edu_type_id == 1) :  ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'exam_type')->widget(Select2::classname(), [
                                'data' => [
                                    0 => 'Online',
                                    1 => 'Offline',
                                ],
                                'options' => ['placeholder' => 'On/Off tanlang ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Online/Offline <span>*</span>'); ?>
                        </div>
                    </div>
                <?php endif;  ?>

            </div>

            <div class="form-group d-flex justify-content-end gap-2">
                <?= Html::submitButton(Yii::t('app', 'Qidirish'), ['class' => 'b-btn b-primary']) ?>
                <?= Html::a(Yii::t('app', 'Reset'), ['index' , 'id' => $edu_type->id], ['class' => 'b-btn b-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

