<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentDtm $model */

$this->title = Yii::t('app', 'Create Student Dtm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Dtms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-dtm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
