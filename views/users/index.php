<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                    // 'mobile',
                    'role',
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
                                return Html::a('<span class="fa fa-edit"></span>แก้ไข', $url, [
                                            'title' => '',
                                            'class' => 'btn btn-primary btn-xs',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span>ลบ', $url, [
                                            'title' => '',
                                            'data-confirm' => Yii::t('yii', 'คุณต้องการลบสมาชิก ใช่ หรือ ไม่?'),
                                            'data-method' => 'post',
                                            'class' => 'btn btn-danger btn-xs',
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
