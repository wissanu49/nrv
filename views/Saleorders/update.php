<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */

$this->title = 'Update Saleorders: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Saleorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saleorders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
