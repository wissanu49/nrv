<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Garbages;
use app\models\Units;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */
$this->title = 'รายละเอียด';
$this->params['breadcrumbs'][] = ['label' => 'รายการขาย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12">  
         
                        <div class="box-body no-padding">
                            <div class="row">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin(); ?>
                    
                    <?= $form->field($model, 'users_id')->textInput(['readonly' => true, 'value'=>$model->users->firstname." ".$model->users->lastname]) ?>
                    
                     <div class="form-group field-saleorders-total_price">
                    <label class="control-label" >ที่อยู่และเบอร์ติดต่อ</label>
                    <textarea readonly="readonly" class="form-control"><?=$model->users->address.' '.$model->users->sub_district.' '.$model->users->district.' '.$model->users->province.' '.$model->users->mobile ?></textarea>
                        <p class="help-block help-block-error"></p>
                    </div>
                    
                    <?= $form->field($model, 'post_timestamp')->textInput(['readonly' => true]) ?>

                    <?= $form->field($model, 'status')->dropDownList([ 'open' => 'เปิดการขาย', 'closed' => 'ปิดการขาย', 'reserve' => 'จอง', 'cancel' => 'ยกเลิกการขาย', ], ['prompt' => 'สถานะ', 'disabled'=> TRUE]) ?>

                   <?php ActiveForm::end(); ?>     
                </div>
                    </div>
                            
                            
                              <table class="table table-condensed">
                                <tr>
                                  <th style="width: 10px">#</th>
                                  <th>รายการ</th>
                                  <th  style="text-align: right;">ราคา/หน่วย</th>
                                  <th  style="text-align: right;">จำนวน</th>
                                  <th  style="text-align: right;">ราคา</th>
                                  
                                  
                                </tr>
                                <?php
                                $i = 0;
                                $sum = 0;
                                    foreach ($dataProvider as $cart){
                                        $gb_unit = Garbages::getUnitsId($cart->garbages_id);
                                        $gb_name = Garbages::getGarbageName($cart->garbages_id);
                                        $gb_price = Garbages::getGarbagePrice($cart->garbages_id);
                                        $unit = Units::getUnitname($gb_unit->units_id);
                                        
                                        $total = $gb_price->price * $cart->amount;
                                        $sum = $sum + $total;
                                ?>
                                <tr>
                                  <td><?=$i+1?>.</td>
                                  <td><?=$gb_name->garbage_name?></td>
                                  <td  style="text-align: right;"><?=$gb_price->price?> บาท</td>
                                  <td  style="text-align: right;"><?=$cart->amount?>&nbsp;<?=$unit->unit_name;?></td>
                                  <td style="text-align: right;"><?=$total?> บาท</td>
                                  
                                 
                                </tr>
                                <?php 
                                $i++;
                                } ?>
                                 <tr>
                                  <td colspan="5"></td>                                 
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td colspan="2" style="text-align: right;"><b>รวม</b> &nbsp;&nbsp;<?=$sum?>&nbsp;บาท</td>                                 
                                </tr>
                              </table>
        <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>
                                
                            </div>
                </div>

</div>
        </div>
     </div>
</section>
