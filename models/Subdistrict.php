<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subdistrict".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $district_id
 *
 * @property District $district
 */
class Subdistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subdistrict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code', 'name'], 'required'],
            [['id', 'district_id'], 'integer'],
            [['code'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 150],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'รหัสตำบล',
            'name' => 'ตำบล',
            'district_id' => 'อำเภอ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
    
    public static function getSubDistrictName($id) {
        $datas = self::find()->select(['name'])->where(['id' => $id])->one();
       if ($datas !== null) {
            return $datas->name;
        } else {
            return NULL;
        }
    }
}