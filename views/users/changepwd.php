<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'เปลี่ยนรหัสผ่าน';
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
 <section class="content">
      <div class="box">
          <div class="box-header with-border">
             <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
          </div>
             <div class="box-body">
            <div class="row">
            <div class="col-md-5">    

                   <?php $form = ActiveForm::begin(); ?>

                   <?= $form->field($model, 'old_password')->passwordInput(['placeholder'=>'รหัสผ่านเดิม']) ?>

                   <?= $form->field($model, 'new_password')->passwordInput(['placeholder'=>'รหัสผ่านใหม่']) ?>

                   <?= $form->field($model, 'repeat_password')->passwordInput(['placeholder'=>'ยืนยันรหัสผ่านใหม่อีกครั้ง']) ?>
            
                  
                   <div class="form-group">
                       <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>&nbsp;
                       <?= Html::submitButton(' เปลี่ยนรหัสผ่าน ', ['class' => 'btn btn-primary']) ?>
                   </div>

                   <?php ActiveForm::end(); ?>

               </div>
                
                </div>        
     </div>
     </div>
 </section>
    </div>
</div>
