<?php


namespace app\models;

use yii;
//use yii\base\Model;

class DepdropThailand extends \yii\db\ActiveRecord
{
    //public $region_id;
    public $province_id;
    public $district_id;
    public $subdistrict_id;

    public function rules()
    {
        return [[ 'province_id', 'district_id', 'subdistrict_id'], 'required']; //'region_id',
    }

    public function attributeLabels()
    {
        return [
            //'region_id' => 'ภาค',
            'province_id' => 'จังหวัด',
            'district_id' => 'อำเภอ',
            'subdistrict_id' => 'ตำบล'
        ];
    }
}