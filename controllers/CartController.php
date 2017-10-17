<?php

namespace app\controllers;

use yii;
use app\models\Cart;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CartController extends Controller
{
    public $enableCsrfValidation = false;
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
        $session = Yii::$app->session;
        $session['cart'] = new \ArrayObject;
        //$session->destroy('cart');
        $carts = \app\models\Garbages::find()->where(['id'=>$session['cart.id']])->all();
        return $this->render('index',['carts'=>$carts]);
        //return $this->render('index');
    }
    
    public function actionAdditem(){
        $session = Yii::$app->session;
        $session->open();
        
        $gid = $session['cart.id'];
        $amount = $session['cart.amount'];
        
        if (isset($_POST['id']) && isset($_POST['amount'])){            
            $gid[] = $_POST['id'];
            $amount[] = $_POST['amount'];
            $session['cart.id'] = $gid;
            $session['cart.amount'] = $amount;            
        }
        
        return $this->redirect(['cart/index']);
    }
    
     public function actionRemoveitem(){
        $session = Yii::$app->session;
        $session->open();
        
        $request = Yii::$app->request;        
        $id = $request->get('id');
        if(isset($id)){
            unset($_SESSION['cart.id'][$id]);
            unset($_SESSION['cart.amount'][$id]);
        }
        
        $gid = $session['cart.id'];
        $amount = $session['cart.amount'];
        return $this->redirect(['cart/index']);
    }
    
    public function actionClear(){
        $session = Yii::$app->session;
        $session->destroy('cart');       
        
        return $this->redirect(['cart/index']);
    }

}
