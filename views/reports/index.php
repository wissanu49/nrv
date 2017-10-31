<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

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
            <div class="col-md-3">    
                <h4>ระบุช่วงเวลาและข้อมูลที่ต้องการ</h4>
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <label>ช่วงเวลา</label>
                    <?=
                    DateRangePicker::widget([
                        'name' => 'date_start',
                        'value' => '',
                        'nameTo' => 'date_end',
                        'valueTo' => '',
                        'language' => 'th',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d'
                        ]
                    ]);
                    ?>
                </div>
                <!--
                <div class="form-group">
                    <label>สิ้นสุดวันที่</label>
                    <?php /*
                    DatePicker::widget([
                        'name' => 'end_date',
                        'value' => '',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d'
                        ]
                    ]);
                     * 
                     */
                    ?>
                </div>
                -->
                <div class="form-group">
                    <label>รายการ</label>
                    <?= Html::dropDownList('list', null,['open'=>'OPEN','closed'=>'CLOSED'],['class'=>'form-control','prompt'=>'-- LIST --']) ?>                   
                </div>

                <div class="form-group">
                <?= Html::submitButton(' ดึงข้อมูล ', ['class' => 'btn btn-success']) ?>
                </div>

<?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</section>
