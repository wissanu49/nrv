<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'ข้อมูลสมาชิก: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'สมาชิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="users-update">

    <?= $this->render('_updateprofile', [
        'model' => $model,
    ]) ?>

</div>
