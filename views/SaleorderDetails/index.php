<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Saleorder Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleorder-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Saleorder Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'weight',
            'price',
            'garbages_id',
            'saleorders_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
