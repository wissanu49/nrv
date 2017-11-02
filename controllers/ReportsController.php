<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UnitsController implements the CRUD actions for Units model.
 */
class ReportsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'admin' || Yii::$app->user->identity->role === 'manager') {
                                return TRUE;
                            }
                            return FALSE;
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

    /**
     * Lists all Units models.
     * @return mixed
     */
    public function actionIndex() {
        
        if(\Yii::$app->request->post()){
            $dataProvider = new \yii\data\SqlDataProvider([
                'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status NOT IN('cancel','closed')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
            ]);
            return $this->render('index',[
                'dataProvider' => $dataProvider,
                'post'=>TRUE,
            ]);
        }else{
            return $this->render('index',[
                'post'=>false,
            ]);
        }
        
    }

}