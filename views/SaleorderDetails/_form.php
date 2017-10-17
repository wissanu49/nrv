<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SaleorderDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saleorder-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'garbages_id')->textInput() ?>

    <?= $form->field($model, 'saleorders_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
