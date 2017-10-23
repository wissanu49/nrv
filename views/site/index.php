<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
$this->title = 'หน้าหลัก';
?>
<section class="content">
     <div class="row">
        <div class="col-lg-6">
            <div class="box">
                
                     <div class="box-header with-border">
                          รายการลงประกาศขาย
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
                         รายการประกาศขาย
                    </div>
                <div class="box-body">  </div>
            </div>
        </div>
                            
    </div>
</section>
