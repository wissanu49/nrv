<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\View;
//use yii\base\NotSupportedException;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $address
 * @property string $sub_district
 * @property string $district
 * @property string $province
 * @property string $lattitude
 * @property string $longitude
 * @property string $image
 * @property string $mobile
 * @property string $role
 *
 * @property Buyorders[] $buyorders
 * @property Saleorders[] $saleorders
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $fullname;
    public $ROLE_Admin      = 'admin';
    public $ROLE_Manager    = 'manager';
    public $ROLE_Seller     = 'seller';
    public $ROLE_Buyer      = 'buyer';
    
    public $old_password;
    public $new_password;
    public $repeat_password;
    
    public $uploadImageFolder = 'uploads/images'; //ที่เก็บรูปภาพ
    
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstname', 'lastname', 'address', 'sub_district', 'district', 'province', 'lattitude', 'longitude', 'mobile', 'role'], 'required'],
            //[['username', 'firstname', 'lastname', 'address', 'sub_district', 'district', 'province', 'lattitude', 'longitude', 'mobile'], 'required', 'on' => 'update'],
            [['role'], 'string'],
            [['username', 'sub_district', 'district', 'image'], 'string', 'max' => 100],
            [['password', 'firstname', 'lastname', 'address', 'province'], 'string', 'max' => 200],
            [['lattitude', 'longitude'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 10],
            [['password','old_password, new_password, repeat_password'], 'required', 'on' => 'changepwd'],
            //['old_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"รหัสผ่านเดิม ไม่ถูกต้อง"],
            ['repeat_password', 'compare', 'compareAttribute'=>'new_password', 'skipOnEmpty' => false, 'message'=>"รหัสผ่านไม่ตรงกัน"],
            //[['old_password', 'findPasswords'],  'on' => 'changepwd'],
            //[['repeat_password'],'compareAttribute'=>'new_password', 'on'=>'changepwd'],
            //[['image'], 'types' => 'jpg'],
            [['username'], 'unique'],
        ];
        
    }
    
    public function scenarios()
    {
        $sn = parent::scenarios();
        $sn['updateProfile'] = ['username', 'firstname', 'lastname', 'address', 'sub_district', 'district', 'province', 'lattitude', 'longitude', 'mobile', 'role'];
        $sn['upImage'] = ['image'];
        $sn['changepwd'] = ['old_password', 'new_password', 'repeat_password'];
        return $sn;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'firstname' => 'ชื่อจริง',
            'lastname' => 'นามสกุล',
            'address' => 'ที่อยู่',
            'sub_district' => 'ตำบล',
            'district' => 'อำเภอ',
            'province' => 'จังหวัด',
            'lattitude' => 'Lattitude',
            'longitude' => 'Longitude',
            'image' => 'รูปภาพ',
            'mobile' => 'มือถือ',
            'role' => 'ประเภทสมาชิก',
            'old_password' => 'รหัสผ่านเดิม',
            'new_password' => 'รหัสผ่านใหม่',
            'repeat_password' => 'ยืนยันรหัสผ่านใหม่'
            
        ];
    }

    
    public function getRole()
    {
        $profile = Profile::find()->where(['user_id'=>$this->id])->one();
        if ($profile !==null){
            return $profile->role;
        }else{
            return false;
        }
    }
   
    /*
    public function isAdmin()
    {
        $role = Profile::find()->where(['user_id'=>$this->id])->one();
        if ($role !==null){
            if($role->role == "admin"){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }
     * 
     */
    
    public function uploadImage(){

        $fileName = $this->getOldAttribute('image');
        //if($this->validate()){
            if($this->image){
                if(($fileName == NULL) || ($fileName == "")){//ถ้าเป็นการเพิ่มใหม่ ให้ตั้งชื่อไฟล์ใหม่
                //if($oldImage == NULL || $oldImage == ""){
                    $fileName = substr(md5(rand(1,1000).time()),0,15).'.'.$this->image->extension;//เลือกมา 15 อักษร .นามสกุล
                }else{
                    $fileName = $this->getOldAttribute('image');      
               // }
                //}else{//ถ้าเป็นการ update ให้ใช้ชื่อเดิม                  
                //    $fileName = $this->getOldAttribute('image');                                    
                }
                $this->image->saveAs(Yii::getAlias('@webroot').'/'.$this->uploadImageFolder.'/'.$fileName);                
                return $fileName;
            }//end image upload
        //}//end validate
        //return $this->isNewRecord ? false : $this->getOldAttribute('image'); //ถ้าไม่มีการ upload ให้ใช้ข้อมูลเดิม
        //return $fileName;
    }
    
     /*
    * getImage เป็น method สำหรับเรียกที่เก็บไฟล์ เพื่อนำไปแสดงผล
    */
    public function getImage()
    {
        return Yii::getAlias('@web').'/web/'.$this->uploadImageFolder.'/'.$this->image;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyorders()
    {
        return $this->hasMany(Buyorders::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleorders()
    {
        return $this->hasMany(Saleorders::className(), ['users_id' => 'id']);
    }
    
    public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        //return $this->getPrimaryKey();
        return $this->id;
    }
    
    public function getUsername()
    {
        return Yii::$app->user->identity->username;
    }
    
    public function getFullname($id)
    {
        $profile = Users::find()->where(['id'=>$id])->one();
        if ($profile !==null){
            $fullname = $profile->firstname." ".$profile->lastname;
            echo $fullname;
        }
        //return false;
    }
    public function Fullname($id)
    {
        $profile = Users::find()->where(['id'=>$id])->one();
        if ($profile !==null){
            $fullname = $profile->firstname." ".$profile->lastname;
            return $fullname;
        }
        //return false;
    }
    public function getAddress($id)
    {
        $profile = Users::find()->where(['id'=>$id])->one();
        if ($profile !==null){
            $address = $profile->address." ต.".$profile->sub_district." อ.".$profile->district." จ.".$profile->province." มือถือ ".$profile->mobile;
            echo $address;
        }
        //return false;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
        //throw  new \yii\base\NotSupportedException();
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw  new \yii\base\NotSupportedException();
    }
    
    public static function findByUsername($username) {
        return self::findOne(['username' => $username]);
    }
    
    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
        //return $this->password === $password;
    }

    public function beforeSave($insert) {
         if (parent::beforeSave($insert)) {
            if ($this->isNewRecord){ // <---- the difference
                $this->authKey = Yii::$app->getSecurity()->generateRandomString();
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }else{
                //$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                //$this->authKey = Yii::$app->getSecurity()->generateRandomString();
            }
            return true;
         }
         return false;
    }
}
