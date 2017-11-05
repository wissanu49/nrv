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
                'only' => ['index', 'seller', 'buyer'],
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
                    [
                        'actions' => ['seller'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'seller') {
                                return TRUE;
                            }
                            return FALSE;
                        },
                    ],
                    [
                        'actions' => ['buyer'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'buyer') {
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

        if (Yii::$app->request->post()) {
            if (isset($_POST['status']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
                if ($_POST['status'] == 'open') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND post_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'closed') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'reserve') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND reserve_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                }
                $dataProvider = new \yii\data\SqlDataProvider([
                    'sql' => $sql,
                    'params' => [':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                ]);
                return $this->render('index', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $_POST['date_from'],
                            'date_to' => $_POST['date_to'],
                ]);
            } else {
                return $this->render('index', [
                            'post' => false,
                ]);
            }
        } else {
            return $this->render('index', [
                        'post' => false,
            ]);
        }
    }

    public function actionSeller() {

        if (Yii::$app->request->post()) {
            if (isset($_POST['status']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
                if ($_POST['status'] == 'open') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND post_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'closed') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'reserve') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND reserve_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                }
                $dataProvider = new \yii\data\SqlDataProvider([
                    'sql' => $sql,
                    'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                ]);
                return $this->render('seller', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $_POST['date_from'],
                            'date_to' => $_POST['date_to'],
                ]);
            } else {
                return $this->render('seller', [
                            'post' => false,
                ]);
            }
        } else {
            return $this->render('seller', [
                        'post' => false,
            ]);
        }
    }

    public function actionBuyer() {

        if (Yii::$app->request->post()) {
            if (isset($_POST['status']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
                if ($_POST['status'] == 'open') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND post_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'closed') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'reserve') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND reserve_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";
                }
                $dataProvider = new \yii\data\SqlDataProvider([
                    'sql' => $sql,
                    'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                ]);
                return $this->render('buyer', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $_POST['date_from'],
                            'date_to' => $_POST['date_to'],
                ]);
            } else {
                return $this->render('buyer', [
                            'post' => false,
                ]);
            }
        } else {
            return $this->render('buyer', [
                        'post' => false,
            ]);
        }
    }

}
