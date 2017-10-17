<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Garbages;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4>เลือกรายการ</h4>
                    
                     <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'garbages_id')->dropDownList(ArrayHelper::map(Garbages::find()->all(), 'id', 'garbage_name')) ?>

                        <?= $form->field($model, 'amount')->textInput() ?>
                    
                        <?= $form->field($model, 'session')->textInput() ?>
                    
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? ' บันทึก ' : ' บันทึการแก้ไข ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    
                    

