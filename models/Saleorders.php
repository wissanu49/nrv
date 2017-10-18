<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "saleorders".
 *
 * @property integer $id
 * @property string $post_timestamp
 * @property string $status
 * @property string $closed_timestamp
 * @property double $total_price
 * @property integer $users_id
 *
 * @property Buyorders[] $buyorders
 * @property SaleorderDetails[] $saleorderDetails
 * @property Users $users
 */
class Saleorders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const _STATUS_OPEN = 'open';
    const _STATUS_CLOSED = 'closed';
    const _STATUS_RESERV = 'reserv';
    const _STATUS_CANCEL = 'cancel';
    
    public static function tableName()
    {
        return 'saleorders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_timestamp', 'status', 'users_id'], 'required'],
            [['post_timestamp'], 'safe'],
            [['status'], 'string'],
            [['total_price'], 'number'],
            [['users_id'], 'integer'],
            [['closed_timestamp'], 'string', 'max' => 45],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_timestamp' => 'ลงประกาศเมื่อ',
            'status' => 'สถานะ',
            'closed_timestamp' => 'ปิดการขายเมื่อ',
            'total_price' => 'ราคารวม / บาท',
            'users_id' => 'โดย',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyorders()
    {
        return $this->hasMany(Buyorders::className(), ['saleorders_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleorderDetails()
    {
        return $this->hasMany(SaleorderDetails::className(), ['saleorders_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
}
