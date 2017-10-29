<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Units */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title"><?php Html::encode($this->title) ?></h3>
            <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?php echo \yii\helpers\Html::a(' ย้อนกลับ ', Yii::$app->request->referrer, ['class' => 'btn btn-info']); ?>
                        <?= Html::submitButton($model->isNewRecord ? 'บันทึก' : 'แก้ไข', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        
                    </div>
                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</section>
