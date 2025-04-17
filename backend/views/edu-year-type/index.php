<?php

use common\models\EduYearForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\EduYear;
use common\models\EduType;

/** @var yii\web\View $this */
/** @var common\models\EduYearFormSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Edu Year Forms');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];

?>
<div class="edu-year-form-index">

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

    <div class="mb-3 mt-4">
        <?= Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'edu_year_id',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_id', ArrayHelper::map(EduYear::find()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Yil bo\'yicha filter ...']),
                'value' => function ($model) {
                    return $model->eduYear->name;
                }
            ],
            [
                'attribute' => 'edu_type_id',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'edu_type_id', ArrayHelper::map(EduType::find()->all(), 'id', 'name_uz'),['class'=>'form-control','prompt' => 'Edu Type bo\'yicha filter ...']),
                'value' => function ($model) {
                    return $model->eduType->name_uz;
                }
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
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function () {
                        return false;
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title'        => 'delete',
                            'class' => 'tableIcon',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
