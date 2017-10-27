<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการขายสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12">  

    <p>
        <?php  
        if(Yii::$app->user->identity->role != "buyer"){
            echo  Html::a('ประกาศขายสินค้า', ['baskets/index'], ['class' => 'btn btn-success']);
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
    <?= GridView::widget([
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
                        return Html::a('รายละเอียด',['saleorders/view','id'=>$data['id']]);
                    },
            ],
            /*
             
            ['class' => 'yii\grid\ActionColumn'],
             * 
             */
        ],
    ]); ?>
    
</div>

</div>
        </div>
     </div>
</section>


