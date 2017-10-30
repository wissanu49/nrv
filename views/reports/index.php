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

$this->title = 'รายงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
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
<section class="content">
    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
            <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
        </div>
        <div class="box-body">
            Report
        </div>
    </div>
</section>
