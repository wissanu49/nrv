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
<div class="saleorders-index">

    <p>
        <?= Html::a('ประกาศขายสินค้า', ['baskets/index'], ['class' => 'btn btn-success']) ?>
        <?php // Html::button('ลงขายสินค้า', ['value'=> Url::to('cart/index'),'class' => 'btn btn-success', 'id'=>'orderButton']) ?>
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
             [
                'attribute' => 'Public at',
                'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => 'post_timestamp',
            ],
            [
                'attribute' => 'Price',
                'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => 'total_price',
            ],
            [
                'attribute' => 'Qty',
                'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => 'Amount',
            ],
            [
                'attribute' => 'Status',
                'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                'value' => 'status',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


