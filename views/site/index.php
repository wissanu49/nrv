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

$coord = new LatLng(['lat'=>14.979827,'lng'=>102.097643]);
$map = new Map([
    'center'=>$coord,
    'zoom'=>12,
    'width'=>'100%',
    'height'=>'600',
]);

foreach($users as $c){
  $coords = new LatLng(['lat'=>$c->lattitude,'lng'=>$c->longitude]);  
  $marker = new Marker(['position'=>$coords]);
  $marker->attachInfoWindow(
    new InfoWindow([
        'content'=>'
     
            <h4>'.$c->firstname.' '.$c->lastname.'</h4>
              <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td>ที่อยู่</td>
                    <td>'.$c->address.' '.$c->sub_district.' '.$c->district.' '.$c->province.' '.$c->mobile.'</td>
                </tr>
              
                <tr>
                    <td></td>
                    <td><a href="saleorders/alldetails/'.$c->id.'" class="btn-xs btn-info">ดูข้อมูล</a></td>
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
        <div class="col-lg-6">
            <div class="box">
                
                     <div class="box-header with-border">
                         <h3>รายการลงประกาศขาย</h3>
                    </div>
                <div class="box-body">  
                     <?php 
                            modal::begin([
                                    'header'=>'<h4>ข้อมูลการขาย</h4>',
                                    'id'=>'modal',
                                    'size'=>'modal-lg',
                                ]);

                                echo "<div id='detailsContent'></div>";

                                modal::end();
                           
                            ?>
                        
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'label' => 'ลงประกาศเมื่อ',
                                    'attribute' => 'post_timestamp',
                                    'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'post_timestamp',
                                ],

                                [
                                    'label' => 'รายการรวม',
                                    'attribute' => 'amount',
                                    'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'amount',
                                ],
                                [
                                    'label' => 'ราคารวม',
                                    'attribute' => 'total_price',
                                    'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'total_price',
                                ],
                                [
                                    'label' => 'สถานะ',
                                    'attribute' => 'status',
                                    'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'status',
                                ],
                                [
                                    'label' => '',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                            return Html::a('รายละเอียด',['saleorders/details','id'=>$data['id']],['class'=>'btn btn-info','id'=>'DetailsButton']);
                                            //return Html::button('รายละเอียด', ['id' => 'DetailsButton', 'value' => \yii\helpers\Url::to(['saleorders/details/'.$data['id']]), 'class' => 'btn btn-info']);
                                        },
                                ],
                                /*
                                 * ['class' => 'yii\grid\ActionColumn'],
                                 * 
                                 */
                            ],
                        ]); ?>
                </div>
            </div>
        </div>
                              
         <div class="col-lg-6">
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
</section>
