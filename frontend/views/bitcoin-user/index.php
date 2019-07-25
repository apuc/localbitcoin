<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BitcoinUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bitcoin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitcoin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bitcoin User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $script = <<< JS
$(document).ready(function() {
    setInterval(function(){
        $('#refreshButton').click();
    }, 10000);
});
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::begin(); ?>
    <p>
        <?= Html::label('1 USD = ' . \common\models\Options::getOption('usd_in_rub')) .' руб.'; ?>
        <br>
        <?= Html::label('Max = ' . \common\models\Options::getOption('max_b')); ?>
    </p>
    <?= Html::a(
        'Обновить',
        ['index'],
        ['class' => 'btn btn-lg btn-primary', 'id' => 'refreshButton', 'style' => ['display' => 'none']]
    ) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'login',
            'balance',
            'dt_add',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
