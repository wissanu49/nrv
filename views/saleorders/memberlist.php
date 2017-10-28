<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Garbages;
use app\models\Units;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Saleorders */
$this->title = 'รายการขายสมาชิก';
$this->params['breadcrumbs'][] = ['label' => 'รายการขายสมาชิก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $users->firstname . ' ' . $users->lastname;
?>
<section class="content">
    <div class="box">
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">  

                    <div class="box-body no-padding">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-condensed">
                                    <tr>
                                        <td><b>ชื่อสมาชิก</b></td>
                                        <td><?= $users->firstname . ' ' . $users->lastname ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>ที่อยู่</b></td>
                                        <td><?= ' เลขที่ ' . $users->address . ' ตำบล ' . $users->sub_district . ' อำเภอ ' . $users->district . ' จังหวัด ' . $users->province ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>หมายเลขโทรศัพท์</b></td>
                                        <td><?= $users->mobile ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'ลงประกาศเมื่อ',
                                    'attribute' => 'post_timestamp',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'post_timestamp',
                                ],
                                [
                                    'label' => 'รายการรวม',
                                    'attribute' => 'amount',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'amount',
                                ],
                                [
                                    'label' => 'ราคารวม',
                                    'attribute' => 'total_price',
                                    'filter' => FALSE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    'value' => 'total_price',
                                ],
                                [
                                    'label' => 'สถานะ',
                                    'format' => 'raw',
                                    //'attribute' => 'status',
                                    //'filter' => FALSE,//กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                    //'value' => 'status',
                                    'value' => function ($data) {
                                        if ($data['status'] == "open") {
                                            return Html::button('OPEN', ['class' => 'btn btn-success btn-sm']);
                                        } else if ($data['status'] == "closed") {
                                            return Html::button('CLOSED', ['class' => 'btn btn-danger btn-sm']);
                                        } else {
                                            return Html::button('OTHER', ['class' => 'btn btn-info btn-sm']);
                                        }
                                    }
                                ],
                                [
                                    'label' => '',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a('รายละเอียด', ['saleorders/details', 'id' => $data['id']], ['class' => 'btn btn-info', 'id' => 'DetailsButton']);
                                        //return Html::button('รายละเอียด', ['id' => 'DetailsButton', 'href' => \yii\helpers\Url::to(['saleorders/details/' . $data['id']]), 'class' => 'btn btn-info']);
                                    },
                                ],
                            /*
                             * ['class' => 'yii\grid\ActionColumn'],
                             * 
                             */
                            ],
                        ]);
                        ?>
                        <?php echo \yii\helpers\Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-info']); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
