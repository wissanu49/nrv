<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'ลงทะเบียนเข้าใช้งาน';
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">    

                            <?php
                            $form = ActiveForm::begin([
                                        'options' => ['enctype' => 'multipart/form-data']
                            ]);
                            ?>

                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>

                            <?= $form->field($model, 'sub_district')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'lattitude')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

                            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

                            <?= $form->field($model, 'image')->fileInput() ?>

<?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'role')->dropDownList(['seller' => 'ลงประกาศขาย', 'buyer' => 'รับซื้อ'], ['prompt' => 'ประเภทสมาชิก']) ?>

                            <div class="form-group">
                            <?= Html::submitButton(' ลงทะเบียน ', ['class' => 'btn btn-primary']) ?>
                            </div>

<?php ActiveForm::end(); ?>

                        </div>
                        <div class="col-md-5">
                            แผนที่
                            <div class="map" style="width: auto; height: 400px;">

                                <?php
                                echo \pigolab\locationpicker\LocationPickerWidget::widget([
                                    'key' => 'AIzaSyB991l8cB4DC63bh5D_GFoWo_gX2pFjFQ0', // require , Put your google map api key
                                    'options' => [
                                        'style' => 'width: 100%; height: 400px', // map canvas width and height
                                    ],
                                    'clientOptions' => [
                                        'location' => [
                                            'latitude' => 14.951150,
                                            'longitude' => 102.197646,
                                        ],
                                        'inputBinding' => [
                                            'latitudeInput' => new JsExpression("$('#users-lattitude')"),
                                            'longitudeInput' => new JsExpression("$('#users-longitude')")
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-2"></div>
</div>
