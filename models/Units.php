<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "units".
 *
 * @property integer $id
 * @property string $unit_name
 *
 * @property Garbages[] $garbages
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_name'], 'required'],
            [['unit_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_name' => 'Unit Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGarbages()
    {
        return $this->hasMany(Garbages::className(), ['units_id' => 'id']);
    }
    
    public function getUnitname($id)
    {
       // $sql = "SELECT unit_name FROM units WHERE id='".$id."'";
        //$result = Units::find()->where('id=:id',[':id' => $id])->all();
        $get = Units::find()->select('unit_name')->where(['id'=>$id])->one();
        //$result = ArrayHelper::map($get, 'id', 'unit_name');
        return $get;
    }
}
