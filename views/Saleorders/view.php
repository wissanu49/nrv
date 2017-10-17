<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Saleorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleorders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'post_timestamp',
            'status',
            'closed_timestamp',
            'total_price',
            'users_id',
        ],
    ]) ?>

</div>
