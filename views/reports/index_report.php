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
                       
                        if ($status == 'open') {
                            echo "รายการที่ยังไม่มีผู้ซื้อ";
                        } else if ($status == 'closed') {
                            echo "รายการที่มีผู้ซื้อแล้ว";
                        } else if ($status == 'reserve') {
                            echo "รายการที่มีการจอง";
                        } else if ($status == 'cancel') {
                            echo "รายการที่ยกเลิก";
                        }
                        echo "<br>ระหว่างวันที่ <b>$date_from</b> ถึงวันที่ <b>$date_to</h3></p>";
                        
                        
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
                                            return 'ประกาศขาย';
                                        } else if ($data['status'] == 'closed') {
                                            return 'ปิดการขาย';
                                        } else if ($data['status'] == 'reserve') {
                                            return 'จอง';
                                        } else if ($data['status'] == 'cancel') {
                                            return 'ยกเลิก';
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
                                [
                                    'label' => 'ผู้ซื้อ',
                                    'attribute' => 'buyers',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => function($data) {
                                        $fullname = \app\models\Users::Fullname($data['buyers']);
                                        return $fullname;
                                    },
                                ]
                            ],
                        ]);
                    
        