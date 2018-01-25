<?php

use app\models\Reports;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GarbagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
         
<p align="center"><h3>รายงานข้อมูล</h3>
<?php
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
                    