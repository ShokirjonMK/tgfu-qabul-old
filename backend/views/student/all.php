<?php

use common\models\StudentDtm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Status;
use kartik\export\ExportMenu;
use yii\widgets\LinkPager;
use common\models\Exam;

/** @var yii\web\View $this */
/** @var common\models\StudentDtmSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\EduYearType $edu_type */

$this->title = Yii::t('app', 'Students');
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$user = Yii::$app->user->identity;
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

    <?php echo $this->render('_all-search', ['model' => $searchModel]); ?>

    <?php $data = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'F.I.O',
            'contentOptions' => ['date-label' => 'F.I.O'],
            'format' => 'raw',
            'value' => function($model) {
                if ($model->user->step == 1) {
                    return "---- ---- ----";
                }
                return $model->last_name.' '.$model->first_name.' '.$model->middle_name;
            },
        ],
        [
            'attribute' => 'Pasport ma\'lumoti',
            'contentOptions' => ['date-label' => 'Pasport ma\'lumoti'],
            'format' => 'raw',
            'value' => function($model) {
                return $model->passport_serial.' '.$model->passport_number." | ".$model->passport_pin;
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
            'attribute' => 'Yo\'nalishi',
            'contentOptions' => ['date-label' => 'Yo\'nalishi'],
            'format' => 'raw',
            'value' => function($model) {
                $direction = $model->direction;
                return $direction->code.' - '.$direction->name_uz;
            },
        ],
        [
            'attribute' => 'Invoise',
            'contentOptions' => ['date-label' => 'Invoise'],
            'format' => 'raw',
            'value' => function($model) {
                $cons = $model->user->cons;
                if ($model->edu_type_id == 1) {
                    $exam = Exam::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'status' => 3,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'>".$exam->contract_second."</div><br><div class='badge-table-div active mt-1'>".$exam->contract_third."</div>";
                    }
                } elseif ($model->edu_type_id == 2) {
                    $exam = \common\models\StudentPerevot::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'>".$exam->contract_second."</div><br><div class='badge-table-div active mt-1'>".$exam->contract_third."</div>";
                    }
                } elseif ($model->edu_type_id == 3) {
                    $exam = StudentDtm::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'>".$exam->contract_second."</div><br><div class='badge-table-div active mt-1'>".$exam->contract_third."</div>";
                    }
                } elseif ($model->edu_type_id == 4) {
                    $exam = \common\models\StudentMagistr::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'>".$exam->contract_second."</div><br><div class='badge-table-div active mt-1'>".$exam->contract_third."</div>";
                    }
                }
                return "----";
            },
        ],
        [
            'attribute' => 'Shartnoma raqam',
            'contentOptions' => ['date-label' => 'Shartnoma raqam'],
            'format' => 'raw',
            'value' => function($model) {
                $cons = $model->user->cons;
                if ($model->edu_type_id == 1) {
                    $exam = Exam::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'status' => 3,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'> ".$cons->code."Q2/".$model->direction->code."/".$exam->id." </div><br><div class='badge-table-div active mt-1'> ".$cons->code."Q3/".$model->direction->code."/".$exam->id." </div>";
                    }
                } elseif ($model->edu_type_id == 3) {
                    $exam = StudentDtm::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'> ".$cons->code."D2/".$model->direction->code."/".$exam->id." </div><br><div class='badge-table-div active mt-1'> ".$cons->code."D3/".$model->direction->code."/".$exam->id." </div>";
                    }
                }  elseif ($model->edu_type_id == 2) {
                    $exam = \common\models\StudentPerevot::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'> ".$cons->code."P2/".$model->direction->code."/".$exam->id." </div><br><div class='badge-table-div active mt-1'> ".$cons->code."P3/".$model->direction->code."/".$exam->id." </div>";
                    }
                } elseif ($model->edu_type_id == 4) {
                    $exam = \common\models\StudentMagistr::findOne([
                        'student_id' => $model->id,
                        'direction_id' => $model->direction_id,
                        'file_status' => 2,
                        'is_deleted' => 0
                    ]);
                    if ($exam) {
                        return "<div class='badge-table-div active'> ".$cons->code."M2/".$model->direction->code."/".$exam->id." </div><br><div class='badge-table-div active mt-1'> ".$cons->code."M3/".$model->direction->code."/".$exam->id." </div>";
                    }
                }
                return "----";
            },
        ],
        [
            'attribute' => 'Domen',
            'contentOptions' => ['date-label' => 'Domen'],
            'format' => 'raw',
            'value' => function($model) {
                $user = $model->user;
                return \common\models\User::getDomen($user->cons_id, 'name') ?? 'old.tgfu.uz';
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

                <div class="page_export">
                    <?php echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $data,
                        'asDropdown' => false,
                    ]); ?>
                </div>

            </div>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $data,
        'pager' => [
            'class' => LinkPager::class,
            'pagination' => $dataProvider->getPagination(),
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'nextPageLabel' => false,
            'prevPageLabel' => false,
            'maxButtonCount' => 10,
        ],
    ]); ?>

</div>
