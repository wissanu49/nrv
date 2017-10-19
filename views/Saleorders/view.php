<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Garbages;
use app\models\Units;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */

$this->title = "รายการขายที่ $model->id";
$this->params['breadcrumbs'][] = ['label' => 'รายการขาย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12">  
    <p>
        <?php // Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(' ลบรายการ ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'post_timestamp',
            'status',
            'closed_timestamp',
            'total_price',
            //'users_id',
        ],
    ]) ?>
    <br>
    
    <div class="box-body no-padding">
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
                                
                            </div>
                </div>

</div>
        </div>
     </div>
</section>
