<?php

use common\models\StudentPerevot;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevotSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'O\'qishni ko\'chirish');
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'O\'qishni ko\'chirish'),
    'url' => ['index'],
];
?>
<div class="student-perevot-index">

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

<!--    <div class="mb-3 mt-4">-->
<!--        --><?php //= Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
<!--    </div>-->


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="form-section">
        <div class="form-section_item">
            <p><b>Jami soni: &nbsp; <?= $dataProvider->totalCount ?></b></p>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'F.I.O',
                'contentOptions' => ['date-label' => 'F.I.O' ,'class' => 'wid250'],
                'format' => 'raw',
                'value' => function($model) {
                    $student = $model->student;
                    return $student->last_name.' '.$student->first_name.' '.$student->middle_name;
                },
            ],
            [
                'attribute' => 'Yo\'nalish',
                'contentOptions' => ['date-label' => 'Yo\'nalish' ,'class' => 'wid250'],
                'format' => 'raw',
                'value' => function($model) {
                    $direction = $model->direction;
                    return $direction->code.' - '.$direction->name_uz;
                },
            ],
            [
                'attribute' => 'file_status',
                'contentOptions' => ['date-label' => 'file_status'],
                'format' => 'raw',
                'value' => function($model) {
                    $text = '';
                    if ($model->file_status == 0) {
                        $text = 'Fayl yo\'q';
                    } elseif ($model->file_status == 1) {
                        $text = 'Kelib tushgan';
                    } elseif ($model->file_status == 2) {
                        $text = 'Tasdiqlandi';
                    } elseif ($model->file_status == 3) {
                        $text = 'Bekor qilindi';
                    }
                    return "<div class='badge-table-div active'><span>". $text ."</span></div>";
                },
            ],
            [
                'attribute' => 'Batafsil',
                'contentOptions' => ['date-label' => 'Batafsil'],
                'format' => 'raw',
                'value' => function($model) {
                    return "<a href='". Url::to(['view' , 'id' => $model->id]) ."' class='badge-table-div active'><span>Batafsil</span></a>";
                },
            ],
        ],
    ]); ?>


</div>
