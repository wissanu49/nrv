<?php

namespace app\controllers;

use Yii;
use app\models\Baskets;
use yii\web\Controller;
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
                'only' => ['index','additem','removeitem','create'],
                'rules' => [
                    [
                        'actions' => ['index','additem','removeitem','create'],
                        'allow' => true,
                        'roles' => ['@'],
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

        //die($model->id);
        $dataprovider = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
        
        if ($model->load(Yii::$app->request->post())){
            
            $model->session = Yii::$app->session->getId();
            $model->users_id = Yii::$app->user->identity->id;   
            $model->id = $model->id + 1;
            if($model->save()){
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
            }else{
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                //print_r($model->getErrors());
            }
            
            $dataprovider = Baskets::find()->where(['users_id'=> Yii::$app->user->identity->id])->all();
            return $this->render('index',['model'=>$model,'dataprovider'=>$dataprovider]);
        }
        
        return $this->render('index',['model'=>$model,'dataprovider'=>$dataprovider]);
    }
    
    public function actionAdditem(){
        
        $model = new Baskets();       
        
         return $this->redirect(['baskets']);
    }
    
     public function actionRemoveitem(){
         
        try{
             if(Yii::$app->request->get()){
             $id = $_GET['id'];
             
             if($this->findModel($id)->delete()){
                Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
            }else{
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
         }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }      
         

        return $this->redirect(['index']);
    }
    
    public function actionClear(){
        $session = Yii::$app->session;
        $session->destroy('cart');       
        
        return $this->redirect(['cart/index']);
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
