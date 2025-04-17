<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Telegram $model */

$this->title = Yii::t('app', 'Create Telegram');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegrams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
