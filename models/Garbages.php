<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Units;
/**
 * This is the model class for table "garbages".
 *
 * @property integer $id
 * @property string $garbage_name
 * @property double $price
 * @property integer $garbage_types_id
 * @property integer $units_id
 *
 * @property GarbageTypes $garbageTypes
 * @property Units $units
 * @property SaleorderDetails[] $saleorderDetails
 */
class Garbages extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'garbages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['garbage_name', 'price','garbage_types_id', 'units_id'], 'required'],
            [['garbage_types_id', 'units_id'], 'integer'],
            [['garbage_name'], 'string', 'max' => 250],
            [['garbage_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => GarbageTypes::className(), 'targetAttribute' => ['garbage_types_id' => 'id']],
            [['units_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['units_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'garbage_name' => 'รายการ',
            'price' => 'ราคา (บาท) / หน่วย',
            'garbage_types_id' => 'ประเภทขยะ',
            'units_id' => 'หน่วยนับ',
        ];
    }

    public function scenarios()
    {
        $sn = parent::scenarios();
        $sn['create'] = ['garbage_name', 'price', 'garbage_types_id','units_id'];
        return $sn;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGarbageTypes()
    {
        return $this->hasOne(GarbageTypes::className(), ['id' => 'garbage_types_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasOne(Units::className(), ['id' => 'units_id']);
    }
    
    public function getUnitsId($id)
    {
        $get = Garbages::find()->select(['units_id'])->where('id=:id',[':id'=>$id])->one();
        return $get;
    }
    
    public function getGarbageName($id)
    {
        $get = Garbages::find()->select(['garbage_name'])->where('id=:id',[':id'=>$id])->one();
        return $get;
    }
    
    public function getGarbageType($id)
    {
        $get = Garbages::find()->select(['garbage_types_id'])->where('id=:id',[':id'=>$id])->one();
        return $get;
    }
    
    public function getGarbagePrice($id)
    {
        $get = Garbages::find()->select(['price'])->where('id=:id',[':id'=>$id])->one();
        return $get;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleorderDetails()
    {
        return $this->hasMany(SaleorderDetails::className(), ['garbages_id' => 'id']);
    }

    public function getCost($withDiscount = true) {
        
    }

    public function getQuantity() {
        
    }

    public function setQuantity($quantity) {
        
    }

    public function getAll()
    {
        $get = Garbages::find()->all();
        $result = ArrayHelper::map($get, 'id', 'garbage_name');
        return $result;
    }

}
