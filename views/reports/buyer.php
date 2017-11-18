<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GarbagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานการซื้อ-ขาย';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
            <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4"> </div>
                <div class="col-md-4">    
                    <h4>ระบุช่วงเวลาและข้อมูลที่ต้องการ</h4>
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group">
                        <label>ช่วงเวลาเริ่มต้น</label>
                        <?= Html::dropDownList('d',NULL, app\models\Reports::getDay(), ['prompt' => 'วันที่','class'=>'form-control']) ?>
                        <?= Html::dropDownList('m',NULL, app\models\Reports::getMonth(), ['prompt' => 'เดือน','class'=>'form-control']) ?>
                        <?= Html::dropDownList('y',NULL, app\models\Reports::getYear(), ['prompt' => 'ปี','class'=>'form-control']) ?>
                    </div>
                    
                     <div class="form-group">
                        <label>ช่วงเวลาสิ้นสุด</label>
                        <?= Html::dropDownList('d2',NULL, app\models\Reports::getDay(), ['prompt' => 'วันที่','class'=>'form-control']) ?>
                        <?= Html::dropDownList('m2',NULL, app\models\Reports::getMonth(), ['prompt' => 'เดือน','class'=>'form-control']) ?>
                        <?= Html::dropDownList('y2',NULL, app\models\Reports::getYear(), ['prompt' => 'ปี','class'=>'form-control']) ?>
                    </div>
                    <div class="form-group">
                        <label>ประเภทสินค้า</label>
                        <?= Html::dropDownList('types',NULL, ArrayHelper::map(app\models\GarbageTypes::find()->all(),'id','type_name'), ['prompt' => 'ประเภทสินค้า','class'=>'form-control']) ?>
                    </div>
                    <!--
                    <div class="form-group">
                        <label>ช่วงเวลา</label>
                        <?php /*
                        DateRangePicker::widget([
                            'name' => 'date_from',
                            'value' => '',
                            'nameTo' => 'date_to',
                            'valueTo' => '',
                            'language' => 'th',
                            'clientOptions' => [
                                'autoclose' => FALSE,
                                'format' => 'yyyy-m-d'
                            ]
                        ]);
                         * 
                         */
                        ?>
                    </div>
                    -->
                    <!--
                    <div class="form-group">
                        <label>สิ้นสุดวันที่</label>
                    <?php /*
                      DatePicker::widget([
                      'name' => 'end_date',
                      'value' => '',
                      'template' => '{addon}{input}',
                      'clientOptions' => [
                      'autoclose' => true,
                      'format' => 'yyyy-m-d'
                      ]
                      ]);
                     * 
                     */
                    ?>
                    </div>
                    -->

                    <div class="form-group">
                        <label>ประเภทรายงาน</label>
                        <?= Html::radioList('status', FALSE, ['closed' => 'รายการซื้อ', 'reserve' => 'รายการจอง'], ['class' => 'form-control']); ?>                  
                    </div>                

                    <div class="form-group">
                        <?= Html::submitButton(' ดูรายงาน ', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($post == TRUE && $type_report == "") {
                        echo "<div align=\"center\">";
                        echo "<p><h3>รายงานใบงาน </b>";
                        if ($status == 'closed') {
                            echo "รายการซื้อ";
                        } else if ($status == 'reserve') {
                            echo "รายการที่มีการจอง";
                        }
                        echo "<br>ระหว่างวันที่ <b>$date_from</b> ถึงวันที่ <b>$date_to</h3></p>";
                        echo "</div>";
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'ลงประกาศเมื่อ',
                                    'attribute' => 'post_timestamp',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'post_timestamp',
                                ],
                                [
                                    'label' => 'จำนวนสินค้า',
                                    'attribute' => 'amount',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => function ($data) {
                                        return $data['amount'] . " รายการ";
                                    }
                                ],
                                [
                                    'label' => 'ราคารวม',
                                    'attribute' => 'total_price',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    //'value' => 'total_price',
                                    'value' => function ($data) {
                                        return $data['total_price'] . " บาท";
                                    }
                                ],
                                [
                                    'label' => 'สถานะ',
                                    //'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => function ($data) {
                                        if ($data['status'] == 'open') {
                                            return Html::a('ประกาศขาย', '', ['class' => 'btn-sm btn-success']);
                                        } else if ($data['status'] == 'closed') {
                                            return Html::a('ปิดการขาย', '', ['class' => 'btn-sm btn-danger']);
                                        } else if ($data['status'] == 'reserve') {
                                            return Html::a('จอง', '', ['class' => 'btn-sm btn-warning']);
                                        } else if ($data['status'] == 'cancel') {
                                            return Html::a('ยกเลิก', '', ['class' => 'btn-sm btn-info']);
                                        }
                                    }
                                ],
                                [
                                    'label' => 'ผู้ขาย',
                                    'attribute' => 'users_id',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => function($data) {
                                        $fullname = \app\models\Users::Fullname($data['users_id']);
                                        return $fullname;
                                    },
                                ],
                                
                            ],
                        ]);
                    }
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($type_report != "") {
                        echo "<div align=\"center\">";
                        echo "<p><h3>รายงานใบงาน </b>";
                        if ($status == 'closed') {
                            echo "รายการซื้อ";
                        } else if ($status == 'reserve') {
                            echo "รายการที่มีการจอง";
                        }
                        echo "<br>ระหว่างวันที่ <b>$date_from</b> ถึงวันที่ <b>$date_to</h3></p>";
                        echo "</div>";
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'ประเภท',
                                    'attribute' => 'type_name ',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'type_name' ,
                                ],
                                [
                                    'label' => 'รายการสินค้า',
                                    'attribute' => 'garbage_name',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'garbage_name',
                                ],                                
                                [
                                    'label' => 'จำนวน',
                                    'attribute' => 'amount',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'amount',
                                ],
                                [
                                    'label' => 'สถานะ',
                                    //'attribute' => 'status',
                                    'format' => 'raw',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => function ($data) {
                                        if ($data['status'] == 'open') {
                                            return Html::a('ประกาศขาย', '', ['class' => 'btn-sm btn-success']);
                                        } else if ($data['status'] == 'closed') {
                                            return Html::a('ปิดการขาย', '', ['class' => 'btn-sm btn-danger']);
                                        } else if ($data['status'] == 'reserve') {
                                            return Html::a('จอง', '', ['class' => 'btn-sm btn-warning']);
                                        } else if ($data['status'] == 'cancel') {
                                            return Html::a('ยกเลิก', '', ['class' => 'btn-sm btn-info']);
                                        }
                                    }
                                ],
                                
                            ],
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
