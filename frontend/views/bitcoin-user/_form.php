<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\BitcoinUser */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="bitcoin-user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apikey')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'secretkey')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
