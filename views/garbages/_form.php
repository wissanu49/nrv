<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Garbages */
/* @var $form yii\widgets\ActiveForm */
?>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'garbage_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'price')->textInput() ?>

                <?= $form->field($model, 'garbage_types_id')->dropDownList(ArrayHelper::map(app\models\GarbageTypes::find()->all(), 'id', 'type_name')) ?>

                <?= $form->field($model, 'units_id')->dropDownList(ArrayHelper::map(app\models\Units::find()->all(), 'id', 'unit_name')) ?>

                <div class="form-group">
                    <?php echo \yii\helpers\Html::a( ' ย้อนกลับ ', Yii::$app->request->referrer, ['class'=>'btn btn-info']); ?>
                    <?= Html::submitButton($model->isNewRecord ? ' บันทึก ' : ' บันทึการแก้ไข ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                
                </div>
                 
                <?php ActiveForm::end(); ?>
               
