<?php

namespace app\controllers;

use Yii;
use app\models\Saleorders;
use app\models\SaleorderDetails;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;

/**
 * SaleordersController implements the CRUD actions for Saleorders model.
 */
class SaleordersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create', 'memberlist', 'selling', 'reserving', 'closed', 'buy'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'create'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role == 'admin' || Yii::$app->user->identity->role == 'seller') {
                                return true;
                            }
                            return false;
                        },
                    ],
                    [
                        'actions' => ['reserving', 'buy'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role == 'buyer') {
                                return true;
                            }
                            return false;
                        },
                    ],
                    [
                        'actions' => ['selling', 'memberlist', 'closed'],
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

    /**
     * Lists all Saleorders models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->identity->role == "admin") {
            //$dataProvider = new ActiveDataProvider([
            //    'query' => Saleorders::find()->select(['saleorders.*','COUNT(saleorder_details.id) AS cnt'])->innerJoin('saleorder_details', 'saleorders.id = saleorder_details.saleorders_id' )->orderBy(['saleorders.id'=>SORT_DESC]),
            //]);            

            //$dataProvider = new SqlDataProvider([
                $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                //'params' => [':uid' => Yii::$app->user->identity->id],
            //]);
                $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                //'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        }
        if (Yii::$app->user->identity->role == "buyer") {
            //$dataProvider = new SqlDataProvider([
                $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status NOT IN('cancel','closed')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                //'params' => [':uid' => Yii::$app->user->identity->id],
            //]);
                $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        } 
        if(Yii::$app->user->identity->role == "seller"){
            //$dataProvider = new SqlDataProvider([
                $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE users_id = :uid 
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                //"params' => [':uid' => Yii::$app->user->identity->id],
            //]);
                $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        }
        

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelling() {
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE status = 'open' 
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
        ]);


        return $this->render('selling', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClosed() {
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE status = 'closed' 
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
        ]);


        return $this->render('closed', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Saleorders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $dataprovider = SaleorderDetails::find()->where(['saleorders_id' => $id])->all();
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {
            if ($model->status == 'closed' || $model->status == 'cancel') {
                $model->closed_timestamp = date('Y:m:d H:m:s');
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'บันรายการเรียบร้อย');
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
        }

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'dataProvider' => $dataprovider,
        ]);
    }

    public function actionAlldetails($id) {

        $dataprovider = SaleorderDetails::find()->where(['saleorders_id' => $id])->all();
        //$model = \app\models\Users::find()->where('id = :id',['id'=>$id])->all();

        return $this->render('alldetails', [
                    'model' => $this->findModel($id),
                    'dataProvider' => $dataprovider,
        ]);
    }

    public function actionMemberlist($id) {

        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE users_id = :uid 
                         AND saleorders.status IN ('open')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
            'params' => [':uid' => $id],
        ]);
        $model = Users::findIdentity($id);
        //die(print_r($model));
        return $this->render('memberlist', [
                    'users' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReserve() {
        if (Yii::$app->user->identity->role == "seller") {
            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE users_id = :uid 
                         AND saleorders.status IN ('reserve')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
                'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        } else if (Yii::$app->user->identity->role == "buyers") {
            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE buyers = :uid 
                         AND saleorders.status IN ('reserve')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
                'params' => [':uid' => Yii::$app->user->identity->id],
            ]);
        }
        //$model = Users::findIdentity($id);
        //die(print_r($model));
        return $this->render('reserve', [
                    //'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReserving() {

        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE buyers = :uid 
                         AND saleorders.status IN ('closed','reserve')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
            'params' => [':uid' => Yii::$app->user->identity->id],
        ]);

        return $this->render('reserve', [
                    //'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBuy() {

        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id)                         
                         WHERE buyers = :uid 
                         AND saleorders.status IN ('closed')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
            'params' => [':uid' => Yii::$app->user->identity->id],
        ]);

        return $this->render('buy', [
                    //'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id) {

        $dataprovider = SaleorderDetails::find()->where(['saleorders_id' => $id])->all();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->buyers = Yii::$app->user->identity->id;
            $model->status = 'reserve';
            $model->reserve_timestamp = date('Y:m:d H:m:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'บันรายการเรียบร้อย');
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
        }


        return $this->render('details', [
                    'model' => $this->findModel($id),
                    'dataProvider' => $dataprovider,
        ]);
    }

    /**
     * Creates a new Saleorders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
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
    public function actionUpdate($id) {
        $model = $this->findModel($id);
         $transection = Yii::$app->db->beginTransaction();
        
        if ($model->load(Yii::$app->request->post())) {

            if ($model->status == 'closed') {
                $model->closed_timestamp = date('Y:m:d H:m:s');
            }
            if ($model->save()) {
                $transection->commit();
                Yii::$app->session->setFlash('success', 'บันรายการเรียบร้อย');
            } else {
                $transection->rollBack();
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Saleorders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
         $transection = Yii::$app->db->beginTransaction();
        //$flag = 0;
        $delete = SaleorderDetails::deleteAll('saleorders_id = :id', [':id' => $id]);
        if ($delete) {
            $this->findModel($id)->delete();
            //die();
           $transection->commit();
            Yii::$app->session->setFlash('success', 'ลบรายการเรียบร้อย');
            return $this->redirect(['saleorders/index']);
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถทำรายการได้');
            $transection->rollBack();
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
    protected function findModel($id) {
        if (($model = Saleorders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
