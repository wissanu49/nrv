<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Units */

$this->title = 'เพิ่มรายการหน่วยนับ';
$this->params['breadcrumbs'][] = ['label' => 'หน่วยนับ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

