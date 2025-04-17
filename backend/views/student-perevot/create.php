<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StudentPerevot $model */

$this->title = Yii::t('app', 'Create Student Perevot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Perevots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-perevot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
