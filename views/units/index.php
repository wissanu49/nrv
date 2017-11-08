<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'หน่วยนับ';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
/*
modal::begin([
    'header' => '<h4>สร้างรายการใหม่</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='unitContent'></div>";
modal::end();

$script = <<< JS
        $(function(){
            $('#createunit').click(function(){
                $('#modal').modal('show')
                        .find('#unitContent')
                        .load($(this).attr('value'))
            });    
        });
JS;

$this->registerJs($script);
 * 
 */
?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
            <?php //echo $this->render('_search', ['model' => $searchModel]);   ?>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

            <p>
                <?= Html::a('เพิ่มรายการใหม่', ['create'], ['class' => 'btn btn-success', 'id'=>'create-garbage'])   ?>
                <?php // Html::button('เพิ่มรายการใหม่', ['value' => Url::to('units/create'), 'class' => 'btn btn-success', 'id' => 'createunit']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'unit_name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view' => function ($model, $key, $index) {
                                return false;
                            },
                            'delete' => function ($model, $key, $index) {
                                return false;
                            }
                        ],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-edit"></span>แก้ไข', $url, [
                                            'title' => '',
                                            'class' => 'btn btn-primary btn-xs',
                                ]);
                            }
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</section>
