<?php

namespace app\controllers;

use Yii;
use app\models\Baskets;
use app\models\Saleorders;
use app\models\SaleorderDetails;
use yii\web\Controller;
use yii\web\Request;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BasketsController extends Controller
{
   public function behaviors()
    {
        return [
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','additem','removeitem','savecart'],
                'rules' => [
                    [
                        'actions' => ['index','additem','removeitem','savecart'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if ( Yii::$app->user->identity->role === 'buyer') {
                                return FALSE;
                            }
                            return TRUE;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $model = new Baskets();
        $model->id = Baskets::find()->count('[[id]]');       

        $transaction = Yii::$app->db->beginTransaction();
        //die($model->id);
        $dataprovider = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
        try{
            if ($model->load(Yii::$app->request->post())){
            
                $model->session = Yii::$app->session->getId();
                $model->users_id = Yii::$app->user->identity->id;   
                $model->id = $model->id + 1;
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    $transaction->commit();
                }else{
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }

                $dataprovider = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
                return $this->render('index',['model'=>$model,'dataprovider'=>$dataprovider]);
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
        }
        
        
        return $this->render('index',['model'=>$model,'dataprovider'=>$dataprovider]);
    }
    
    public function actionSavecart(){       
           
        $basketsModel = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
        
        $transaction = Yii::$app->db->beginTransaction();
        try{
            //Find out how many products have been submitted by the form
            //$count = count(Yii::$app->request->post('Baskets', []));

            $orderModel = new Saleorders();    
            //$suborderModel = [new SaleorderDetails()];     

            //Create an array of the products submitted
            //for($i = 1; $i < $count; $i++) {
            //    $suborderModel[] = new SaleorderDetails();
            //}
            //die('save');
            
            if(Yii::$app->request->post()){
                $flag = 0;
                // Load Basket
                $basketsModel = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
                
                // Create Order                
                $orderModel = new Saleorders();
                $orderModel->id = Saleorders::find()->count('[[id]]');
                $orderModel->id = $orderModel->id + 1;
                $orderModel->post_timestamp = date('Y:m:d H:m:s');
                $orderModel->status = Saleorders::_STATUS_OPEN;
                $orderModel->total_price = $_POST['Baskets']['summary'];
                $orderModel->closed_timestamp = NULL;
                $orderModel->users_id = Yii::$app->user->identity->id;
                
                $orderModel->save();
                if(!$orderModel->save()){
                    Yii::$app->session->setFlash('error', 'ไม่สามารถสร้างใบงานขายได้');
                    $flag = $flag + 1;
                }
                
                // COPY Baskets To SubOrder
                foreach ($basketsModel as $cart) {
                    
                    $suborderModel = new SaleorderDetails();
                    $suborderModel->id = SaleorderDetails::find()->count('[[id]]');
                    $suborderModel->id = $suborderModel->id+1;
                    
                    $suborderModel->garbages_id = $cart->garbages_id;
                    $suborderModel->amount = $cart->amount;
                    $suborderModel->saleorders_id = $orderModel->id;
                    $suborderModel->save();
                    
                    if(!$suborderModel->save()){
                        $flag = $flag + 1;       
                         Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                    }
                      
                }
                /// Delete baskets
                Baskets::deleteAll('users_id = :uid OR session = :session', [':uid' => Yii::$app->user->identity->id, ':session' => Yii::$app->session->getId()]);
               
                if($flag == 0){                        
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    $transaction->commit();                
                    return $this->redirect(['saleorders/index']);
                }else{                    
                    $transaction->rollBack();    
                    return $this->redirect(['saleorders/index']);
                }
                
            }
            //Load and validate the multiple models
            /*
            if (Model::loadMultiple($suborderModel, Yii::$app->request->post()) && Model::validateMultiple($suborderModel)) {

                foreach ($suborderModel as $sub) {
                    die('for');
                    //Try to save the models. Validation is not needed as it's already been done.
                   // $sub->save(false);
                   print_r($sub, $return);
                    /*
                    if(!$this->findModel($sub->id)->delete()){
                        $transaction->rollBack();
                    }
                     * 
                     

                }
                
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                $transaction->commit();
                return $this->redirect('index');
            }
             * 
             */
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            $transaction->rollBack();
        }

        return $this->render('save_form',['basketModel'=>$basketsModel]);
            
    }
    
     public function actionRemoveitem(){
        $transaction = Yii::$app->db->beginTransaction();
        try{
             if(Yii::$app->request->get()){
             $id = $_GET['id'];
             
             if($this->findModel($id)->delete()){
                Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
                $transaction->commit();
            }else{
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
         }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
            $transaction->rollBack();
        }      
         

        return $this->redirect(['index']);
    }
    
    public function actionClear(){
       
    }
    
    protected function findModel($id)
    {
        if (($model = Baskets::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
