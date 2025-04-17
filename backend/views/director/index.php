<?php

use common\models\Employee;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\EmployeeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Direktorlar');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];

?>
<div class="employee-index">

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'first_name',
            'last_name',
            'middle_name',
            'phone',
            'gender',
            //'password',
            //'status',
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
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
