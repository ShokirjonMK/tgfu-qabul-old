<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Direction $model */


$this->title = $model->name_uz;
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Yo\'nalishlar'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="direction-view">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <p class="mb-3 mt-4">
        <?= Html::a(Yii::t('app', 'Tahrirlash'), ['update', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
        <?= Html::a(Yii::t('app', 'O\'chirish'), ['delete', 'id' => $model->id], [
            'class' => 'b-btn b-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->edu_type_id == 1) : ?>
            <?= Html::a(Yii::t('app', 'Fanlar'), ['direction-subject/index', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
        <?php elseif ($model->edu_type_id == 2) : ?>
            <?= Html::a(Yii::t('app', 'Bosqichlar'), ['direction-course/index', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
        <?php endif; ?>

    </p>

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name_uz',
                'name_ru',
                'name_en',
                'code',
                [
                    'attribute' => 'edu_year_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->eduYear->name;
                    },
                ],
                'edu_duration',
                [
                    'attribute' => 'contract',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return number_format($model->contract  ,2,'.',' ');
                    },
                ],
                [
                    'attribute' => 'language_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->language->name_uz;
                    },
                ],
                [
                    'attribute' => 'edu_year_type_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->eduType->name_uz;
                    },
                ],
                [
                    'attribute' => 'edu_year_form_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->eduForm->name_uz;
                    },
                ],
                [
                    'attribute' => 'status',
                    'contentOptions' => ['date-label' => 'adress'],
                    'format' => 'raw',
                    'value' => function($model) {
                        if ($model->status == 1) {
                            return "<div class='badge-table-div active'><span>Faol</span></div>";
                        } elseif ($model->status == 0) {
                            return "<div class='badge-table-div inactive'><span>No faol</span></div>";
                        }
                    },
                ],
                [
                    'attribute' => 'oferta',
                    'contentOptions' => ['date-label' => 'adress'],
                    'format' => 'raw',
                    'value' => function($model) {
                        if ($model->oferta == 1) {
                            return "<div class='badge-table-div active'><span>Bor</span></div>";
                        } elseif ($model->oferta == 0) {
                            return "<div class='badge-table-div inactive'><span>Yo'q</span></div>";
                        }
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return date('Y-m-d -- H:i:s' , $model->created_at);
                    },
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return date('Y-m-d -- H:i:s' , $model->updated_at);
                    },
                ],
                'created_by',
                'updated_by',
            ],
        ]) ?>
    </div>

</div>
