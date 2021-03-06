<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$fullname = app\models\Users::Fullname(Yii::$app->user->identity->id);
$this->title = 'รายการขายสำเร็จ : '.$fullname;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="box">
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">  

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
                                'label' => 'ปิดการขายเมื่อ',
                                'attribute' => 'closed_timestamp',
                                'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                'value' => 'closed_timestamp',
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


