<?php

namespace app\controllers;

use Yii;
use app\models\Saleorders;
use app\models\SaleorderDetails;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * SaleordersController implements the CRUD actions for Saleorders model.
 */
class SaleordersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Saleorders models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role == "admin"){
            //$dataProvider = new ActiveDataProvider([
            //    'query' => Saleorders::find()->orderBy(['id'=>SORT_DESC]),
            //]);            
            
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT post_timestamp, total_price, status, COUNT(saleorder_details.id) AS Amount ' . 
                         'FROM saleorders ' .
                         'INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) ' .
                         //'INNER JOIN ArticleTags ON (Articles.ID = ArticleTags.ID) ' .
                         'WHERE users_id=:uid' ,
                         //'GROUP BY ArticleID',
                'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        }else{
            $dataProvider = new ActiveDataProvider([
                'query' => Saleorders::find()->where('users_id = :uid', [':uid'=>Yii::$app->user->identity->id])->orderBy(['id'=>SORT_DESC]),
            ]);
        }
        

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Saleorders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Saleorders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Saleorders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Saleorders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Saleorders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        //$flag = 0;
        $delete = SaleorderDetails::deleteAll('saleorders_id = :id', [':id' => $id]);
        if($delete){
                        
            $this->findModel($id)->delete();
            //die();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'ลบรายการเรียบร้อย');            
            return $this->redirect(['saleorders/index']);
        }else{
            Yii::$app->session->setFlash('error', 'ไม่สามารถทำรายการได้');
            $transaction->rollBack();
            return $this->redirect(['saleorders/index']);
        }
        
        
        
    }

    /**
     * Finds the Saleorders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Saleorders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Saleorders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
