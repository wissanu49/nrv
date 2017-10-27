<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\web\JsExpression;

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

            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data']
                ]); ?>     
         
           <?php //echo Yii::getAlias('@web')."/web";
           
           if($model->image){ echo Html::img($model->getImage(), ['class' => 'img-responsive', 'width' => '250px']) ;}
           ?>

            <?= $form->field($model, 'image')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? ' บันทึก ' : ' บันทึกการแก้ไข ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
          
         </div>        
     </div>
     </div>
 </section>
