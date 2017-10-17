<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SaleorderDetails */

$this->title = 'Create Saleorder Details';
$this->params['breadcrumbs'][] = ['label' => 'Saleorder Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleorder-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
