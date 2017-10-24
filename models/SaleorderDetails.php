<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "saleorder_details".
 *
 * @property integer $id
 * @property double $weight
 * @property double $price
 * @property integer $garbages_id
 * @property integer $saleorders_id
 *
 * @property Garbages $garbages
 * @property Saleorders $saleorders
 */
class SaleorderDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'saleorder_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['garbages_id', 'saleorders_id'], 'required'],
            [['garbages_id', 'saleorders_id'], 'integer'],
            [['garbages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Garbages::className(), 'targetAttribute' => ['garbages_id' => 'id']],
            [['saleorders_id'], 'exist', 'skipOnError' => true, 'targetClass' => Saleorders::className(), 'targetAttribute' => ['saleorders_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'น้ำหนัก',
            'garbages_id' => 'รายการ',
            'saleorders_id' => 'เลขที่',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGarbages()
    {
        return $this->hasOne(Garbages::className(), ['id' => 'garbages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleorders()
    {
        return $this->hasOne(Saleorders::className(), ['id' => 'saleorders_id']);
    }
}
