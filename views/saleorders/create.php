<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */

$this->title = 'Create Saleorders';
$this->params['breadcrumbs'][] = ['label' => 'Saleorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saleorders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
