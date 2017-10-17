<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = 'Update Garbages: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Garbages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'units_id' => $model->units_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="garbages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
