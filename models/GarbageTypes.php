<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "garbage_types".
 *
 * @property integer $id
 * @property string $type_name
 * @property string $type_description
 *
 * @property Garbages[] $garbages
 */
class GarbageTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'garbage_types';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type_name'], 'string', 'max' => 250],
            [['type_description'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type_name' => 'ประเภทขยะ',
            'type_description' => 'รายละเอียด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGarbages() {
        return $this->hasMany(Garbages::className(), ['garbage_types_id' => 'id']);
    }

    public function getGarbageTypeName($id) {
        $get = GarbageTypes::find()->select(['type_name'])->where('id=:id', [':id' => $id])->one();
        return $get;
    }

}
