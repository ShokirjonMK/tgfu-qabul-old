<?php

use common\models\Questions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Subjects $subject */
/** @var common\models\QuestionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Savollar');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => 'Fanlar ( '.$subject->name_uz . ' )',
    'url' => ['subjects/index' , 'id' => $subject->id],
];

$questions = $dataProvider->getModels();
?>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<div class="questions-index">

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
        <?= Html::a(Yii::t('app', 'Savol qo\'shish'), ['create' , 'id' => $subject->id], ['class' => 'b-btn b-primary']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Savol matni',
                'contentOptions' => ['date-label' => 'Savol matni' ,'style' => 'max-width: 300px;'],
                'format' => 'raw',
                'value' => function($model) {
                    return $model->text;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'entered' => function ($url, $model) {
                        if ($model->status == 1) {
                            return false;
                        } else {
                            $url = Url::to(['check', 'id' => $model->id]);
                            return Html::a('<i class="fa-solid fa-check"></i>', $url, [
                                'title'        => 'Tasdiqlash',
                                'class' => 'tableIcon',
                                'data-confirm' => Yii::t('yii', 'Savol tasdiqlansinmi?'),
                                'data-method'  => 'post',
                            ]);
                        }
                    },
                    'view'   => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'view',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if ($model->status == 1) {
                            return false;
                        } else {
                            $url = Url::to(['update', 'id' => $model->id]);
                            return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                                'title' => 'update',
                                'class' => 'tableIcon',
                            ]);
                        }
                    },
                    'delete' => function ($url, $model) {
                        if ($model->status == 1) {
                            return false;
                        } else {
                            $url = Url::to(['delete', 'id' => $model->id]);
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                'title'        => 'delete',
                                'class' => 'tableIcon',
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method'  => 'post',
                            ]);
                        }
                    },
                ]
            ],
        ],
    ]); ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

</div>
