<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = 'สร้างรายการขยะ';
$this->params['breadcrumbs'][] = ['label' => 'รายการขยะ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="garbages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
