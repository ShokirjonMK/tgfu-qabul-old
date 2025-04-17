<?php

use common\models\Exam;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\ExamSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\Student $student */

$this->title = Yii::t('app', 'Qabul');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
?>
<div class="exam-index">

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
        <?php // Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute' => 'status',
                'contentOptions' => ['date-label' => 'status'],
                'format' => 'raw',
                'value' => function($model) {
                    $text = '';
                    if ($model->status == 0) {
                        $text = 'Bekor qilindi';
                    } elseif ($model->status == 1) {
                        $text = 'Testga kirmagan';
                    } elseif ($model->status == 2) {
                        $text = 'Testda';
                    } elseif ($model->status == 3) {
                        $text = 'Yakunlagan';
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
