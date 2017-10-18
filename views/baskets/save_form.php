<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Garbages;
use app\models\Units;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Garbages */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'บันทึกรายการขายสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'รายการขาย', 'url' => ['baskets/index']];
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
?>
 <section class="content">
     <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">  
                <?php $form = ActiveForm::begin(); ?>
                     <table class="table table-condensed">
                                <tr>
                                  <th style="width: 10px">#</th>
                                  <th>รายการ</th>
                                  <th style="text-align: right;">ราคา/หน่วย</th>
                                  <th style="text-align: right;">จำนวน</th>
                                  <th style="text-align: right;">ราคา</th>
                                </tr>
                                <?php
                                $i = 0;
                                $sum = 0;
                                    foreach ($basketModel as $index => $suborderModel){
                                        echo $form->field($suborderModel, "[$index]garbages_id")->hiddenInput(['value'=> $suborderModel->garbages_id])->label(false);
                                        echo $form->field($suborderModel, "[$index]amount")->hiddenInput(['value'=> $suborderModel->amount])->label(false);
                                        
                                        $gb_unit = Garbages::getUnitsId($suborderModel->garbages_id);
                                        $gb_name = Garbages::getGarbageName($suborderModel->garbages_id);
                                        $gb_price = Garbages::getGarbagePrice($suborderModel->garbages_id);
                                        $unit = Units::getUnitname($gb_unit->units_id);
                                        
                                        $total = $gb_price->price * $suborderModel->amount;
                                        $sum = $sum + $total;
                                ?>
                                <tr>
                                  <td><?=$i+1?>.</td>
                                  <td><?=$gb_name->garbage_name?></td>
                                  <td style="text-align: right;"><?=$gb_price->price?> บาท</td>
                                  <td style="text-align: right;"><?=$suborderModel->amount?>&nbsp;<?=$unit->unit_name;?></td>
                                  <td style="text-align: right;"><?=$total?> บาท</td>
                                 
                                </tr>
                                <?php 
                                $i++;
                                } 
                                
                                echo $form->field($suborderModel, "summary")->hiddenInput(['value'=> $sum])->label(false);
                                ?>
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
                <div class="form-group">
                    <?= Html::submitButton(' บันทึก ', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
     </div>
 </section>
