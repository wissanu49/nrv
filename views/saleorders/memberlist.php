<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Garbages;
use app\models\Units;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */
$this->title = 'รายละเอียด';
$this->params['breadcrumbs'][] = ['label' => 'รายการขายสมาชิก', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $users->firstname;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12">  
         
                        <div class="box-body no-padding">
    
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
                                    'format' => 'raw',
                                    //'attribute' => 'status',
                                    //'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    //'value' => 'status',
                                    'value' => function ($data){
                                        if($data['status'] == "open"){
                                           return Html::button('OPEN',['class'=>'btn btn-success btn-sm']);
                                        }else if($data['status'] == "closed"){
                                            return Html::button('CLOSED',['class'=>'btn btn-danger btn-sm']);
                                        }else{
                                            return Html::button('OTHER',['class'=>'btn btn-info btn-sm']);
                                        }
                                    }
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
        <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>
                                
                            </div>
                </div>

</div>
        </div>
     </div>
</section>