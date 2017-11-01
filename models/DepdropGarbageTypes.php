<?php
namespace app\models;

use yii;

class DepdropGarbageTypes extends \yii\db\ActiveRecord
{
    public $GarbageTypes_id;
    public $Garbages_id;

    public function rules()
    {
        return [['garbageTypes_id', 'garbages_id'], 'required'];
    }

    public function attributeLabels()
    {
        return [
            'garbageTypes_id' => 'ประเภทขยะ',
            'garbages_id' => 'รายการขยะ',
        ];
    }
}