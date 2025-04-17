<?php

use common\models\StudentDtm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\StudentDtmSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Student Dtms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-dtm-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Student Dtm'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'student_id',
            'direction_id',
            'file',
            //'file_status',
            //'contract_type',
            //'contract_price',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'is_deleted',
            //'contract_second',
            //'contract_third',
            //'contract_link',
            //'down_time:datetime',
            //'confirm_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, StudentDtm $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
