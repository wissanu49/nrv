<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'ข้อมูลสมาชิก: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'สมาชิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<section class="content">
     <div class="box">
             
        <div class="box-body">
            <div class="row">
             
                <div class="col-md-12">  
    <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>
                    
    <?= $this->render('_updateprofile', [
        'model' => $model,
    ]) ?>

 </div>
            </div>

        </div>
     </div>
 </section>
