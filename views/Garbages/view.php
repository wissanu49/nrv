<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = $model->garbage_name;
$this->params['breadcrumbs'][] = ['label' => 'รายการสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
     <div class="box">
        <div class="box-body">
                
            <div class="row">
                <div class="col-md-12">  

    <p>
        <?= Html::a(' แก้ไข ', ['update', 'id' => $model->id, 'units_id' => $model->units_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(' ลบรายการ ', ['delete', 'id' => $model->id, 'units_id' => $model->units_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'garbage_name',
            'price',
            [
                        'attribute' => 'garbage_types_id',
                        'filter' => ArrayHelper::map(app\models\GarbageTypes::find()->all(), 'id', 'type_name'),//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                        'value' => function($model){
                            return $model->garbageTypes->type_name;
                        }
                    ],
             [
                        'attribute' => 'units_id',
                        'filter' => ArrayHelper::map(app\models\Units::find()->all(), 'id', 'unit_name'),//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                        'value' => function($model){
                            return $model->units->unit_name;
                        }
                    ],
        ],
    ]) ?>
     <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>

 </div>

</div>
        </div>
     </div>
</section>
