<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\DirectionSubject $model */
/** @var common\models\Direction $direction */

$this->title = Yii::t('app', 'Tahrirlash: {name}', [
    'name' => $model->subject->name_uz,
]);
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
    'label' => Yii::t('app', 'Fanlar'),
    'url' => ['direction-subject/index' , 'id' => $direction->id],
];

?>
<div class="direction-subject-update">

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
        'direction' => $direction
    ]) ?>

</div>
