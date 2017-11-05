<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\View;

//use yii\base\NotSupportedException;

class Reports {

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date_from', 'date_to', 'status'], 'required'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'date_from' => 'วันที่เริ่ม',
            'date_to' => 'วันที่สิ้นสุด',
            'status' => 'รายการ',
        ];
    }


}
