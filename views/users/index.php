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
    <?= GridView::widget([
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
             </div>
     </div>
 </section>
