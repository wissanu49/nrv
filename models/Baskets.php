<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "baskets".
 *
 * @property integer $id
 * @property integer $garbages_id
 * @property double $amount
 * @property integer $users_id
 */
class Baskets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baskets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'garbages_id', 'amount', 'users_id'], 'required'],
            [['id', 'garbages_id', 'users_id'], 'integer'],
            [['amount'], 'number'],
            [['session'],'string', 'max' => 50],
            [['garbages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Garbages::className(), 'targetAttribute' => ['garbages_id' => 'id']],
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
            'garbages_id' => 'สินค้า',
            'amount' => 'จำนวน',
            'users_id' => 'Users ID',
            'session' => 'SESSION ID',
        ];
    }
    
    public function getLastID(){
        $max = Baskets::find()->max('id');
        return $max+1;
    }
}
