<?php

use common\models\StudentDtm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Status;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var common\models\StudentDtmSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Students');
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$user = Yii::$app->user->identity;
$thisRole = $user->user_role;
?>
<div class="student-dtm-index">

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

    <?php echo $this->render('_user-step-search', ['model' => $searchModel]); ?>

    <?php $data = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'O\'chirish',
            'contentOptions' => ['date-label' => 'O\'chirish'],
            'format' => 'raw',
            'value' => function($model) {
                return Html::a("<span>O'chirish</span>", ['dele', 'id' => $model->id], [
                    'class' => 'badge-table-div danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Rostdan ma\'lumotni o\'chirmoqchimisiz?'),
                        'method' => 'post',
                    ],
                ]);
            },
        ],
        [
            'attribute' => 'F.I.O',
            'contentOptions' => ['date-label' => 'F.I.O' ,'class' => 'wid250'],
            'format' => 'raw',
            'value' => function($model) {
                if ($model->user->step == 1) {
                    return "---- ---- ----";
                }
                return $model->last_name.' '.$model->first_name.' '.$model->middle_name;
            },
        ],
        [
            'attribute' => 'Tel raqam',
            'contentOptions' => ['date-label' => 'Tel raqam'],
            'format' => 'raw',
            'value' => function($model) {
                return $model->user->username;
            },
        ],
        [
            'attribute' => 'Parol',
            'contentOptions' => ['date-label' => 'Parol'],
            'format' => 'raw',
            'value' => function($model) {
                return $model->password;
            },
        ],
        [
            'attribute' => 'SMS parol',
            'contentOptions' => ['date-label' => 'SMS parol'],
            'format' => 'raw',
            'value' => function($model) {
                $user = $model->user;
                if ($user->sms_time > time()) {
                    return $model->user->sms_number;
                }
                return "-----";
            },
        ],
        [
            'attribute' => 'Ro\'yhatga olingan sana',
            'contentOptions' => ['date-label' => 'Ro\'yhatga olingan sana'],
            'format' => 'raw',
            'value' => function($model) {
                return date("Y-m-d H:i" , $model->user->created_at);
            },
        ],
        [
            'attribute' => 'Status',
            'contentOptions' => ['date-label' => 'Status'],
            'format' => 'raw',
            'value' => function($model) {
                if ($model->user->status == 10) {
                    return "<div class='badge-table-div active'><span>Faol</span></div>";
                } else {
                    return "<div class='badge-table-div active'><span>To'liq ro'yhatdan o'tmagan</span></div>";
                }
            },
        ],
        [
            'attribute' => 'step',
            'contentOptions' => ['date-label' => 'step'],
            'format' => 'raw',
            'value' => function($model) {
                $user = $model->user;
                $text = '';
                if ($user->status == 9 && $user->step == 1) {
                    $text = 'SMS kod tasdiqlamagan';
                } elseif ($user->status == 10 && $user->step == 1) {
                    $text = "Pasport ma'lumotini kiritmagan";
                } elseif ($user->status == 10 && $user->step == 2) {
                    $text = "Qabul turini tanlamagan";
                } elseif ($user->status == 10 && $user->step == 3) {
                    $text = "Yo'nalish tanlamagan";
                } elseif ($user->status == 10 && $user->step == 4) {
                    $text = "Tasdiqdlamagan";
                } elseif ($user->status == 0) {
                    $text = "Bloklangan";
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
    ]; ?>

    <div class="form-section">
        <div class="form-section_item">
            <div class="d-flex justify-content-between align-items-center">
                <p><b>Jami soni: &nbsp; <?= $dataProvider->totalCount ?></b></p>

                <?php if ($thisRole == 'admin' || $thisRole == 'supper_admin'): ?>
                    <div class="page_export">
                        <?php echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $data,
                            'asDropdown' => false,
                        ]); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $data,
    ]); ?>

</div>
