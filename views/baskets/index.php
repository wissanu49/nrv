<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Garbages;
use app\models\Units;
use yii\helpers\Url;

$this->title = 'เพิ่มรายการขายสินค้า';
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-3">  
                    <h4>เลือกรายการ</h4>
                    
                     <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'garbages_id')->dropDownList(ArrayHelper::map(Garbages::find()->all(), 'id', 'garbage_name')) ?>

                        <?= $form->field($model, 'amount')->textInput() ?>
                        <?php // $form->field($model, 'users_id')->textInput() ?>
                    
                        <div class="form-group">
                            <?= Html::submitButton(' เพิ่ม ', ['class' =>'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-9">  
                    <h4>รายการสินค้า</h4>
                    <?php //Yii::$app->session->getId()?>
                         <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                              <table class="table table-condensed">
                                <tr>
                                  <th style="width: 10px">#</th>
                                  <th>รายการ</th>
                                  <th>ราคา/หน่วย</th>
                                  <th>จำนวน</th>
                                  
                                  <th style="width: 10px">ยกเลิก</th>
                                  
                                </tr>
                                <?php
                                $i = 0;
                                    foreach ($dataprovider as $cart){
                                        $gb_unit = Garbages::getUnitsId($cart->garbages_id);
                                        $gb_name = Garbages::getGarbageName($cart->garbages_id);
                                        $gb_price = Garbages::getGarbagePrice($cart->garbages_id);
                                        $unit = Units::getUnitname($gb_unit->units_id);
                                ?>
                                <tr>
                                  <td><?=$i+1?>.</td>
                                  <td><?=$gb_name->garbage_name?></td>
                                  <td><?=$gb_price->price?> บาท</td>
                                  <td><?=$cart->amount?>&nbsp;<?=$unit->unit_name;?></td>
                                  
                                  <td>                                      
                                      <?= Html::a('x', ['/baskets/removeitem', 'id'=>$cart->id], ['class'=>'btn btn-danger']) ?>
                                  </td>
                                 
                                </tr>
                                <?php 
                                $i++;
                                } ?>
                              </table>
                                
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                          <div>
                              <?= Html::a(' บันทึกรายการ ', ['/baskets/savecart',], ['class'=>'btn btn-info']) ?>
                          </div>
                </div>
            </div>

        </div>
     </div>
 </section>

