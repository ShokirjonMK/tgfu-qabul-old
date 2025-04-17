<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CrmPush $model */

$this->title = Yii::t('app', 'Create Crm Push');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crm Pushes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-push-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
