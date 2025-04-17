<?php

use common\models\DirectionCourse;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Course;

/** @var yii\web\View $this */
/** @var common\models\DirectionCourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\Direction $direction */

$this->title = Yii::t('app', 'Bosqich qo\'shish');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Yo\'nalish ( '. $direction->name_uz. ' )'),
    'url' => ['direction/view' , 'id' => $direction->id],
];
?>
<div class="direction-course-index">

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
        <?= Html::a(Yii::t('app', 'Qo\'shish'), ['create' , 'id' => $direction->id], ['class' => 'b-btn b-primary']) ?>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'course_ud',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->course->name_uz;
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
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'gridActionColumn'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'view',
                            'class' => 'tableIcon',
                        ]);
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
