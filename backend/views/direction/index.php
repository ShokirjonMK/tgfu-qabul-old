<?php

use common\models\Direction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Languages;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\EduYear;
use kartik\select2\Select2;
use common\models\Status;
use common\models\Student;
use common\models\Exam;
use common\models\StudentDtm;
use common\models\StudentPerevot;
use common\models\StudentMagistr;

/** @var yii\web\View $this */
/** @var common\models\DirectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Yo\'nalishlar');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$user = Yii::$app->user->identity;
$eduYear = EduYear::findOne(['status' => 1, 'is_deleted' => 0]);
$eduYearTypes = EduYearType::getEduTypeName($eduYear);
$eduYearForms = EduYearForm::getEduFormName($eduYear);
$baseQuery = Student::find()
    ->alias('s')
    ->innerJoin('user u', 's.user_id = u.id')
    ->where(['u.cons_id' => $user->cons_id, 'u.user_role' => 'student']);

$exam = Exam::find()
    ->where(['is_deleted' => 0]);
$dtm = StudentDtm::find()
    ->where(['is_deleted' => 0]);
$perevot = StudentDtm::find()
    ->where(['is_deleted' => 0]);
$magister = StudentMagistr::find()
    ->where(['is_deleted' => 0]);

?>
<div class="direction-index">

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
                'attribute' => 'name_uz',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->code. ' - ' .$model->name_uz;
                },
                'contentOptions' => ['class' => 'wid250'],
            ],

//            [
//                'attribute' => 'Fanlar',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    $t = \common\models\DirectionSubject::find()->where(['direction_id' => $model->id, 'status' => 1 , 'is_deleted' => 0])->all();
//                    if (count($t)) {
//                        $p = '';
//                        foreach ($t as $y) {
//                             $p .= $y->subject->name_uz."<br>";
//                        }
//                        return $p;
//                    }
//                },
//                'contentOptions' => ['class' => 'wid250'],
//            ],
            'edu_duration',
            [
                'attribute' => 'contract',
                'format' => 'raw',
                'value' => function ($model) {
                    return number_format($model->contract  ,0,'.',' ');
                },
            ],
            [
                'attribute' => 'language_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->language->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'language_id',
                    ArrayHelper::map(Languages::find()->where(['status' => 1, 'is_deleted' => 0])->all(), 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Til ...']),
            ],
            [
                'attribute' => 'edu_year_type_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduType->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_type_id',
                    $eduYearTypes,
                    ['class'=>'form-control','prompt' => 'Tur ...']),
            ],
            [
                'attribute' => 'edu_year_form_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->eduForm->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_year_form_id',
                    $eduYearForms,
                    ['class'=>'form-control','prompt' => 'Shakl ...']),
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
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    Status::accessStatus(),
                    ['class'=>'form-control','prompt' => 'Status ...']),
            ],
            [
                'attribute' => 'Arizalar',
                'format' => 'raw',
                'value' => function ($model) use ($exam,$dtm,$perevot, $magister) {
                    $examCount = (clone $exam)
                        ->andWhere(['direction_id' => $model->id]);
                    $dtmCount = (clone $dtm)
                        ->andWhere(['direction_id' => $model->id]);
                    $perevotCount = (clone $perevot)
                        ->andWhere(['direction_id' => $model->id]);
                    $magisterCount = (clone $magister)
                        ->andWhere(['direction_id' => $model->id]);

                    $eCount = (clone $examCount)
                        ->andWhere(['<' , 'status' , 3])->count();
                    $dCount = (clone $dtmCount)
                        ->andWhere(['<' , 'file_status' , 2])->count();
                    $pCount = (clone $perevotCount)
                        ->andWhere(['<' , 'file_status' , 2])->count();
                    $mCount = (clone $magisterCount)
                        ->andWhere(['<' , 'file_status' , 2])->count();

                    $eCountb = (clone $examCount)
                        ->andWhere(['=' , 'status' , 4])->count();
                    $dCountb = (clone $dtmCount)
                        ->andWhere(['file_status' => 3])->count();
                    $pCountb = (clone $perevotCount)
                        ->andWhere(['file_status' => 3])->count();
                    $mCountb = (clone $magisterCount)
                        ->andWhere(['file_status' => 3])->count();

                    $kutilmoqda = $eCount + $dCount + $pCount + $mCount;
                    $bekor = $eCountb + $dCountb + $pCountb + $mCountb;
                    $jami = $examCount->count() + $dtmCount->count() + $perevotCount->count() + $magisterCount->count();

                    return "<div><div class='badge-table-div active mb-2'>Jami: ".$jami."</div><br><div class='badge-table-div active mb-2'>K/B: ". $kutilmoqda ." / ".$bekor."</div></div>";
                },
            ],
            [
                'attribute' => 'Shartnoma',
                'format' => 'raw',
                'value' => function ($model) use ($exam,$dtm,$perevot, $magister) {
                    $examCount = (clone $exam)
                        ->andWhere(['status' => 3, 'direction_id' => $model->id]);
                    $dtmCount = (clone $dtm)
                        ->andWhere(['file_status' => 2, 'direction_id' => $model->id]);
                    $perevotCount = (clone $perevot)
                        ->andWhere(['file_status' => 2, 'direction_id' => $model->id]);
                    $magisterCount = (clone $magister)
                        ->andWhere(['file_status' => 2, 'direction_id' => $model->id]);

                    $eCount = (clone $examCount)
                        ->andWhere(['>' , 'down_time' , 0])->count();
                    $dCount = (clone $dtmCount)
                        ->andWhere(['>' , 'down_time' , 0])->count();
                    $pCount = (clone $perevotCount)
                        ->andWhere(['>' , 'down_time' , 0])->count();
                    $mCount = (clone $magisterCount)
                        ->andWhere(['>' , 'down_time' , 0])->count();
                    $olgan = $eCount + $dCount + $pCount + $mCount;
                    $jami = $examCount->count() + $dtmCount->count() + $perevotCount->count() + $magisterCount->count();

                    return "<div><div class='badge-table-div active mb-2'>Olgan: ". $olgan ."</div><br><div class='badge-table-div active'>Olmagan: ".$jami - $olgan."</div></div>";
                },
            ],
            [
                'attribute' => '',
                'contentOptions' => ['date-label' => 'adress'],
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->edu_type_id == 1) {
                        return "<div class='badge-table-div active'><a href='". Url::to(['direction-subject/index' , 'id' => $model->id]) ."'><span>Fanlar</span></a></div>";
                    } elseif ($model->edu_type_id == 2) {
                        return "<div class='badge-table-div active'><a href='". Url::to(['direction-course/index' , 'id' => $model->id]) ."'><span>Kurslar</span></a></div>";
                    } else {
                        return false;
                    }
                }
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