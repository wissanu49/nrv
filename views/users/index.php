<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สมาชิก';
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
                <?= Html::a('เพิ่มสมาชิกใหม่', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'username',
                    //'password',
                    'firstname',
                    'lastname',
                    // 'address',
                    // 'sub_district',
                    // 'district',
                    // 'province',
                    // 'lattitude',
                    // 'longitude',
                    // 'image',                    
                    'role',
                     [
                                //'label' => 'สถานะ',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => TRUE, //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                'value' => function ($data) {
                                    if ($data['status'] == 'active') {
                                        return Html::a('active', '', ['class' => 'btn-sm btn-success']);
                                    } else if ($data['status'] == 'suspend') {
                                        return Html::a('suspend', '', ['class' => 'btn-sm btn-danger']);
                                    } 
                                }
                            ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'visibleButtons' => [
                            'view' => function ($model, $key, $index) {
                                return false;
                            }
                        ],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('แก้ไข', $url, [
                                            'title' => '',
                                            'class' => 'btn btn-primary btn-xs',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('Active / Suspend', $url, [
                                            'title' => '',
                                            'data-confirm' => Yii::t('yii', 'คุณต้องการเปลี่ยนสถานะสมาชิก ใช่ หรือ ไม่?'),
                                            'data-method' => 'post',
                                            'class' => 'btn btn-warning btn-xs',
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
