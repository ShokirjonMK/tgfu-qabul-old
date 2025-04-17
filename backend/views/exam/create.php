<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Exam $model */

$this->title = Yii::t('app', 'Create Exam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Exams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
