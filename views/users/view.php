<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = "ข้อมูลสมาชิก : ".$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12"> 

    <h1><?php //Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('ลบข้อมูล', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่ ?',
                'method' => 'post',
            ],
        ]) 
         * 
         */
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
            //'password',
            'firstname',
            'lastname',
            'address',
            'sub_district',
            'district',
            'province',
            'lattitude',
            'longitude',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => $model->image ? Html::img($model->getImage(), ['class' => 'img-responsive', 'width' => '150px']) : null
            ],
            'mobile',
            'role',
        ],
    ]) ?>
</div>

</div>
        </div>
     </div>
</section>
