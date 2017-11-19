<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $province_id
 *
 * @property Province $province
 * @property Subdistrict[] $subdistricts
 */
class District extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'code', 'name'], 'required'],
            [['id', 'province_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 150],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'code' => 'รหัสอำเภอ',
            'name' => 'อำเภอ',
            'province_id' => 'จังหวัด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince() {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubdistricts() {
        return $this->hasMany(Subdistrict::className(), ['district_id' => 'id']);
    }

    public static function getDistrictName($id) {
        $datas = self::find()->select(['name'])->where(['id' => $id])->one();
        if ($datas !== null) {
            return $datas->name;
        } else {
            return NULL;
        }
    }

}
