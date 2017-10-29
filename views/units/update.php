<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Units */

$this->title = 'แก้ไขรายการ: ' . $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="units-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
