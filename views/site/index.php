<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;

/* @var $this yii\web\View */

$coord = new LatLng(['lat' => 14.979827, 'lng' => 102.097643]);
$map = new Map([
    'center' => $coord,
    'zoom' => 12,
    'width' => '100%',
    'height' => '600',
        ]);

foreach ($users as $c) {
    $coords = new LatLng(['lat' => $c->lattitude, 'lng' => $c->longitude]);
    $address = \app\models\Users::getAddressUser($c->id);
    $marker = new Marker(['position' => $coords]);
    $marker->attachInfoWindow(
            new InfoWindow([
        'content' => '
     
            <h4>' . $c->firstname . ' ' . $c->lastname . '</h4>
              <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td>ที่อยู่</td>
                    <td>เลขที่ ' . $address . '</td>
                </tr>
              
                <tr>
                    <td></td>
                    <td><a href="saleorders/memberlist/' . $c->id . '" class="btn-xs btn-info">ดูข้อมูล</a></td>
                </tr>
              </table>

        '
            ])
    );

    $map->addOverlay($marker);
}


$this->title = 'หน้าหลัก';
?>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3>แผนที่ผู้ลงประกาศขาย</h3>
                </div>
                <div class="box-body"> 
                    <?php
                    echo $map->display();
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="box">

                <div class="box-header with-border">
                    <h3>รายการลงประกาศขาย</h3>
                </div>
                <div class="box-body">  
                    <?php
                    modal::begin([
                        'header' => '<h4>ข้อมูลการขาย</h4>',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);

                    echo "<div id='detailsContent'></div>";

                    modal::end();
                    ?>

                    <?=
                    GridView::widget([
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
                                    return Html::a('รายละเอียด', ['saleorders/details', 'id' => $data['id']], ['class' => 'btn-sm btn-info', 'id' => 'DetailsButton']);
                                    //return Html::button('รายละเอียด', ['id' => 'DetailsButton', 'value' => \yii\helpers\Url::to(['saleorders/details/'.$data['id']]), 'class' => 'btn btn-info']);
                                },
                            ],
                        /*
                         * ['class' => 'yii\grid\ActionColumn'],
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
