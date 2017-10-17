<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GarbagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการขยะ';
$this->params['breadcrumbs'][] = $this->title;
?>
   
 <section class="content">
     <div class="box">
          <div class="box-header with-border">

             <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
            <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
      </div>
             <div class="box-body">
            <p>
                <?= Html::a('เพิ่มรายการใหม่', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    //'id',
                    'garbage_name',
                    'price',
                    //'units.unit_name',
                    //'garbageTypes.type_name',
                    [
                        'attribute' => 'units_id',
                        'filter' => ArrayHelper::map(app\models\Units::find()->all(), 'id', 'unit_name'),//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                        'value' => function($model){
                            return $model->units->unit_name;
                        }
                    ],
                    [
                        'attribute' => 'garbage_types_id',
                        'filter' => ArrayHelper::map(app\models\GarbageTypes::find()->all(), 'id', 'type_name'),//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                        'value' => function($model){
                            return $model->garbageTypes->type_name;
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
             </div>
     </div>
 </section>
