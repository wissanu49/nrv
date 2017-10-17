<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Garbages;
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
                    <form id="form-cart" method="post" action="<?= Url::to(['cart/additem']); ?>">
                    <?= Html::dropDownList('id',NULL, Garbages::getAll(), ['prompt' => '--- เลือกรายการ ---','class'=>'form-control']) ?>
                     <div class="form-group">
                        <label class="control-label">จำนวน</label>
                        <input type="text" class="form-control required" name="amount" id="weight" value="1">
                    </div>
                    
                
                <div class="form-group">
                   
                    
                    <input type="submit" class="btn btn-primary" value=" เพิ่ม ">
                </div>

                    </form>
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
                                if(isset($carts)){
                                    foreach ($carts as $cart){
                                        $unit = Garbages::getUnitname($cart->units_id);
                                ?>
                                <tr>
                                  <td><?=$i+1?>.</td>
                                  <td><?=$cart->garbage_name ?></td>
                                  <td><?=$cart->price?> บาท</td>
                                  <td><?=$session['cart.amount'][$i]?>&nbsp;<?=$unit?></td>
                                  
                                  <td>                                      
                                      <?= Html::a('x', ['/cart/removeitem', 'id'=>$i], ['class'=>'btn btn-danger']) ?>
                                  </td>
                                 
                                </tr>
                                <?php 
                                $i++;
                                    }
                                } ?>
                              </table>
                                
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                          <div>
                              <?= Html::a(' เคลียร์ ', ['/cart/clear',], ['class'=>'btn btn-danger']) ?>
                              <?= Html::a(' บันทึก ', ['/cart/',], ['class'=>'btn btn-info']) ?>
                          </div>
                </div>
            </div>

        </div>
     </div>
 </section>

