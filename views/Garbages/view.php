<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Garbages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="garbages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'units_id' => $model->units_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'units_id' => $model->units_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'garbage_name',
            'price',
            'garbage_types_id',
            'units_id',
        ],
    ]) ?>

</div>
