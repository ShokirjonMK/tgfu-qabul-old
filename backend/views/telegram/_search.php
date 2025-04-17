<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\TelegramSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telegram-search">

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
                        <?= $form->field($model, 'passport_serial') ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'passport_number') ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <?= $form->field($model, 'phone')
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
                        <?= $form->field($model, 'bot_status')->widget(Select2::classname(), [
                            'data' => Status::botStatus(),
                            'options' => ['placeholder' => 'Status tanlang ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Status <span>*</span>');; ?>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end gap-2">
                <?= Html::submitButton(Yii::t('app', 'Qidirish'), ['class' => 'b-btn b-primary']) ?>
                <?= Html::a(Yii::t('app', 'Reset'), ['index'], ['class' => 'b-btn b-secondary']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
