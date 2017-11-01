<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ลงประกาศขาย';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="box">
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">  

                    <p>
                        <?php
                        if (Yii::$app->user->identity->role != "buyer") {
                            echo Html::a('ประกาศขายสินค้า', ['baskets/index'], ['class' => 'btn btn-success']);
                        }
                        ?>
                    </p>

                    <?php
                    /* ใช้งาน popup
                      modal::begin([
                      'header'=>'<h4>เพิ่มรายการสินค้า</h4>',
                      'id'=>'modalOrder',
                      'size'=>'modal-lg',
                      ]);

                      echo "<div id='orderContent'></div>";

                      modal::end();
                     * 
                     */
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //'id',
                            //'post_timestamp',
                            //'total_price',
                            //'amount',
                            //'status',
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
                                'label' => '',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('รายละเอียด', ['saleorders/view', 'id' => $data['id']], ['class' => 'btn-sm btn-info']);
                                },
                            ],
                        /*
                          [
                          'class' => 'yii\grid\ActionColumn',
                          'buttonOptions'=>['class'=>'btn btn-default'],
                          'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view}{delete} </div>',
                          ],
                         * 
                         */
                        ],
                    ]);
                    ?>

                </div>

            </div>
        </div>
    </div>
</section>


