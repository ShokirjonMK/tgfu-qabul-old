<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\DirectionCourse $model */
/** @var common\models\Direction $direction */

$this->title = Yii::t('app', 'Yangi bosqich biriktirish');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Yo\'nalish ( '. $direction->name_uz. ' )'),
    'url' => ['direction/view' , 'id' => $direction->id],
];

$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosqichlar'),
    'url' => ['direction-course/index' , 'id' => $direction->id],
];


?>
<div class="direction-course-create">

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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
