<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Garbages;
use app\models\Units;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */

$this->title = "รายการขาย";
$this->params['breadcrumbs'][] = ['label' => 'รายการขาย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="box">
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">  

                    <?php if ($model->users_id == Yii::$app->user->identity->id || Yii::$app->user->identity->role == "admin" && $model->status != 'closed' ) { ?>
                        <?=
                        Html::a(' ลบรายการ ', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่?',
                                'method' => 'post',
                            ],
                        ])
                        ?>
<?php } ?>
                    <div class="row">
                        <div class="col-md-6">

                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'post_timestamp')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'total_price')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'status')->dropDownList(['open' => 'เปิดการขาย', 'closed' => 'ปิดการขาย', 'reserve' => 'จอง', 'cancel' => 'ยกเลิกการขาย',], ['prompt' => 'สถานะ', 'disabled' => $model->status == 'closed' ? TRUE : FALSE]) ?>

                                <?= $form->field($model, 'closed_timestamp')->textInput(['readonly' => true]) ?>
                            <div class="form-group">
                                <?php
                                if ($model->status != 'closed') {
                                    echo Html::submitButton(' บันทึก ', ['class' => 'btn btn-primary']);
                                }
                                ?>
                            </div>

                            <?php ActiveForm::end(); ?>               
                            <br>
                        </div>
                    </div>
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
                            foreach ($dataProvider as $cart) {
                                $gb_unit = Garbages::getUnitsId($cart->garbages_id);
                                $gb_name = Garbages::getGarbageName($cart->garbages_id);
                                $gb_price = Garbages::getGarbagePrice($cart->garbages_id);
                                $unit = Units::getUnitname($gb_unit->units_id);

                                $total = $gb_price->price * $cart->amount;
                                $sum = $sum + $total;
                                ?>
                                <tr>
                                    <td><?= $i + 1 ?>.</td>
                                    <td><?= $gb_name->garbage_name ?></td>
                                    <td  style="text-align: right;"><?= $gb_price->price ?> บาท</td>
                                    <td  style="text-align: right;"><?= $cart->amount ?>&nbsp;<?= $unit->unit_name; ?></td>
                                    <td style="text-align: right;"><?= $total ?> บาท</td>


                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td colspan="5"></td>                                 
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2" style="text-align: right;"><b>รวม</b> &nbsp;&nbsp;<?= $sum ?>&nbsp;บาท</td>                                 
                            </tr>
                        </table>
<?php echo \yii\helpers\Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-info']); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
