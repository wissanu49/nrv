<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = 'แก้ไขรายการ: ' . $model->garbage_name;
$this->params['breadcrumbs'][] = ['label' => 'รายการสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->garbage_name, 'url' => ['view', 'id' => $model->id, 'units_id' => $model->units_id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
 <section class="content">
     <div class="box">
             
        <div class="box-body">
            <div class="row">
             
                <div class="col-md-5">  
                    <p>
                        <?= Html::a(' ลบรายการ ', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'คุณต้องการลบรายการนี้ ใช่หรือไม่?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>                    

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                   
 </div>
            </div>

        </div>
     </div>
 </section>
