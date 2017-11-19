<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $region_id
 *
 * @property District[] $districts
 * @property Region $region
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code', 'name'], 'required'],
            [['id', 'region_id'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 150],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'รหัสจังหวัด',
            'name' => 'จังหวัด',
            'region_id' => 'ภาค',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['province_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public static function getProvinceName($id) {
        $datas = self::find()->select(['name'])->where(['id' => $id])->one();
        if ($datas !== null) {
            return $datas->name;
        } else {
            return NULL;
        }
    }
}