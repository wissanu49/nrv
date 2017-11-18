<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
//$this->title = 'เพิ่มสมาชิกใหม่';
?>
 <section class="content">
      <div class="box">
             <div class="box-body">
     <div class="row">
     <div class="col-md-5">    

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field('', 'รายการ')->dropDownList([ 'seller' => 'ลงประกาศขาย', 'buyer' => 'รับซื้อ', 'admin' => 'ผู้ดูแลระบบ', 'manager' => 'ผู้บริหาร', ], ['prompt' => 'ประเภทสมาชิก']) ?>

            <div class="form-group">
                <?= Html::submitButton(' ดูรายงาน ', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

</div>
         </div>        
     </div>
     </div>
 </section>
