<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Garbages */

$this->title = 'สร้างรายการขยะ';
$this->params['breadcrumbs'][] = ['label' => 'รายการขยะ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
     <div class="box">
             
        <div class="box-body">
            <div class="row">
             
                <div class="col-md-12">  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

 </div>
            </div>

        </div>
     </div>
 </section>
