<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GarbagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
<?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
        </div>
        <div class="box-body">
<?php
modal::begin([
    'header' => '<h4>สร้างรายการสินค้า</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='createContent'></div>";
modal::end();

$script = <<< JS
        $(function(){
            $('#creategarbage').click(function(){
                $('#modal').modal('show')
                        .find('#createContent')
                        .load($(this).attr('value'))
            });    
        });
JS;

$this->registerJs($script);
        
?>


            <p>
<?php // Html::a('เพิ่มรายการใหม่', ['create'], ['class' => 'btn btn-success', 'id'=>'create-garbage'])  ?>
<?= Html::button('เพิ่มรายการใหม่', ['value' => Url::to('garbages/create'), 'class' => 'btn btn-success', 'id' => 'creategarbage']) ?>
            </p>
                <?=
                GridView::widget([
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
                            'filter' => ArrayHelper::map(app\models\Units::find()->all(), 'id', 'unit_name'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                            'value' => function($model) {
                                return $model->units->unit_name;
                            }
                        ],
                        [
                            'attribute' => 'garbage_types_id',
                            'filter' => ArrayHelper::map(app\models\GarbageTypes::find()->all(), 'id', 'type_name'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                            'value' => function($model) {
                                return $model->garbageTypes->type_name;
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
        </div>
    </div>
</section>
