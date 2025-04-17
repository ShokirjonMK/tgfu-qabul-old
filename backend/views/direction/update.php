<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Direction $model */
/** @var common\models\EduYear $eduYear */

$this->title = Yii::t('app', 'Update Direction: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Directions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="direction-update">

    <?= $this->render('_form', [
        'model' => $model,
        'eduYear' => $eduYear,
    ]) ?>

</div>
