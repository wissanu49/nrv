<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saleorders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_timestamp')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'open' => 'Open', 'closed' => 'Closed', 'reserve' => 'Reserve', 'cancel' => 'Cancel', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'closed_timestamp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'users_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
