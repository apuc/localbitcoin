<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BitcoinUser */

$this->title = 'Create Bitcoin User';
$this->params['breadcrumbs'][] = ['label' => 'Bitcoin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitcoin-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
