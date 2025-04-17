<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevotSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-perevot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
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
                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => Status::eStatus(),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end gap-2">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'b-btn b-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'b-btn b-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
