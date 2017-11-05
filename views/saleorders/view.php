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


                    <div class="col-md-4">

<?php $form = ActiveForm::begin(); ?>

                        <div class="form-group">
                            <label class="control-label">ผู้ประกาศขาย</label>                        

<?= Html::textInput('user', $model->users->firstname . ' ' . $model->users->lastname, ['class' => 'form-control', 'readonly' => 'readonly']); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">ที่อยู่</label>                        

<?= Html::textInput('address', $model->users->address . ' ต.' . $model->users->sub_district . ' อ.' . $model->users->district . ' จ.' . $model->users->province . ' มือถือ ' . $model->users->mobile, ['class' => 'form-control', 'readonly' => 'readonly']); ?>
                        </div>

                        <?= $form->field($model, 'post_timestamp')->textInput(['readonly' => true]) ?>
                        <?php if (Yii::$app->user->identity->id == $model->id) { ?>
                            <?= $form->field($model, 'status')->dropDownList(['open' => 'เปิดการขาย', 'closed' => 'ปิดการขาย', 'reserve' => 'จอง', 'cancel' => 'ยกเลิกการขาย',], ['prompt' => 'สถานะ', 'disabled' => $model->status == 'closed' ? TRUE : FALSE]) ?>
                        <?php } else { ?>
                            <?= $form->field($model, 'status')->dropDownList(['open' => 'เปิดการขาย', 'closed' => 'ปิดการขาย', 'reserve' => 'จอง', 'cancel' => 'ยกเลิกการขาย',], ['prompt' => 'สถานะ', 'disabled' => TRUE]) ?>
                            <?php } ?>
                        <div class="form-group">
                            <?php echo \yii\helpers\Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-info']); ?>
                            <?php
                            if ($model->users_id == Yii::$app->user->identity->id && $model->status != 'closed') {


                                echo Html::a(' ลบรายการ ', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่?',
                                        'method' => 'post',
                                    ],
                                ]);
                                echo '&nbsp;';
                                echo Html::submitButton(' บันทึก ', ['class' => 'btn btn-primary']);
                            }
                            ?>
                        </div>

<?php ActiveForm::end(); ?>               
                        <br>
                    </div>
                    <div class="col-md-8">
                        <?php
                        if ($model->status == 'reserve') {
                            //$fullname = app\models\Users::getFullname($model->buyers);
                            ?>
                            <table class="table table-condensed">
                                <tr>
                                    <td style="text-align: left;"><strong>ผู้จอง</strong></td>
                                    <td style="text-align: left;"><?= app\models\Users::getFullname($model->buyers) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>ที่อยู่</strong></td>
                                    <td><?= app\models\Users::getAddress($model->buyers) ?></td>
                                </tr>
                            </table>
<?php } ?>

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


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
