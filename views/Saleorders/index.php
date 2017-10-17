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

            'id',
            'post_timestamp',
            'status',
            'closed_timestamp',
            'total_price',
            // 'users_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script>
function addCart(id){
    alert(id);
}
</script>
<?php
$this->registerJs("
        $('#garbage_id').change(function(){ 
             $('#gid').val($(this).val());
        });");  
        
?>

