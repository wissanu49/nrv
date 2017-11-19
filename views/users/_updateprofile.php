<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use app\models\Province;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
//$this->title = 'เพิ่มสมาชิกใหม่';
?>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">    

                    <?php $form = ActiveForm::begin(); ?>

                    <?php if ($model->image) {
                        echo Html::img($model->getImage(), ['class' => 'img-responsive', 'width' => '250px']);
                    } ?>
                    <br>

                    <?= Html::a('เปลี่ยนรูปภาพประจำตัว', ['users/uploadimg', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'province')->dropDownList(ArrayHelper::map(Province::find()->all(), 'id', 'name'), ['prompt' => 'เลือกจังหวัด']) ?>

                    <?=
                    $form->field($model, 'district')->widget(DepDrop::className(), [
                        //'options' => ['id' => 'dt-id'],
                        'data' => $district,
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($model, 'province')],
                            //'depends' => ['pv-id'],
                            'placeholder' => 'เลือกอำเภอ',
                            'url' => Url::to(['districtlist'])
                        ]
                    ])
                    ?>
                    <?=
                    $form->field($model, 'sub_district')->widget(DepDrop::className(), [
                        //'options' => ['id' => 'sdt-id'],
                        'data' => $subdistrict,
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($model, 'district')],
                            //'depends' => ['dt-id'],
                            'placeholder' => 'เลือกตำบล',
                            'url' => Url::to(['subdistrictlist'])
                        ]
                    ])
                    ?>
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                    <?php //$form->field($model, 'sub_district')->textInput(['maxlength' => true]) ?>

                    <?php // $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

                    <?php // $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'lattitude')->textInput(['maxlength' => true, 'readOnly' => true]) ?>

                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true]) ?>


                    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

                    <?php
                    if (Yii::$app->user->identity->role == "admin") {

                        echo $form->field($model, 'role')->dropDownList(['seller' => 'ลงประกาศขาย', 'buyer' => 'รับซื้อ', 'admin' => 'ผู้ดูแลระบบ', 'manager' => 'ผู้บริหาร',], ['prompt' => 'ประเภทสมาชิก']);
                    }
                    ?>


                    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? ' เพิ่มข้อมูล ' : ' บันทึกการแก้ไข ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>



                </div>
                <div class="col-md-5">
                    แผนที่
                    <div class="map" style="width: 500px; height: 400px;">

                        <?php
                        echo \pigolab\locationpicker\LocationPickerWidget::widget([
                            'key' => 'AIzaSyB991l8cB4DC63bh5D_GFoWo_gX2pFjFQ0', // require , Put your google map api key
                            'options' => [
                                'style' => 'width: 100%; height: 400px', // map canvas width and height
                            ],
                            'clientOptions' => [
                                'location' => [
                                    'latitude' => $model->lattitude,
                                    'longitude' => $model->longitude,
                                //'latitude'  => 14.979827 ,
                                //'longitude' => 102.097643,
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
                <?php ActiveForm::end(); ?>
            </div>        
        </div>
    </div>
</section>
