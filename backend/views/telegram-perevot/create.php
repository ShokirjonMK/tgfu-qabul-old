<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TelegramPerevot $model */

$this->title = Yii::t('app', 'Create Telegram Perevot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Perevots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-perevot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
