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

            $date_from = $_POST['y'] . "-" . $_POST['m'] . "-" . $_POST['d'];
            $date_to = $_POST['y2'] . "-" . $_POST['m2'] . "-" . $_POST['d2'];

            //if (isset($_POST['status']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
            if (isset($_POST['status']) && isset($_POST['d']) && isset($_POST['m']) && isset($_POST['y']) && isset($_POST['d2']) && isset($_POST['m2']) && isset($_POST['y2'])) {
                if ($_POST['status'] == 'open') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND post_timestamp BETWEEN :date_from AND :date_to";
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
                         AND reserve_timestamp BETWEEN :date_from AND :date_to";
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to";
                }

                $sql .= " GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC";

                $dataProvider = new \yii\data\SqlDataProvider([
                    'sql' => $sql,
                    //'params' => [':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                    'params' => [':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                ]);
                return $this->render('index', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $date_from, //$_POST['date_from'],
                            'date_to' => $date_to, // $_POST['date_to'],
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
                         AND post_timestamp BETWEEN :date_from AND :date_toC";
                } else if ($_POST['status'] == 'closed') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to";
                } else if ($_POST['status'] == 'reserve') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND reserve_timestamp BETWEEN :date_from AND :date_to";
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE users_id = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to";
                }

                $sql .= "GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                $dataProvider = new \yii\data\SqlDataProvider([
                    'sql' => $sql,
                    //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                    'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                ]);
                return $this->render('seller', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $date_from, //$_POST['date_from'],
                            'date_to' => $date_to, // $_POST['date_to'],
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
            $date_from = $_POST['y'] . "-" . $_POST['m'] . "-" . $_POST['d'];
            $date_to = $_POST['y2'] . "-" . $_POST['m2'] . "-" . $_POST['d2'];

            if (isset($_POST['status']) && isset($_POST['d']) && isset($_POST['m']) && isset($_POST['y']) && isset($_POST['d2']) && isset($_POST['m2']) && isset($_POST['y2'])) {
                //if (isset($_POST['status']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
                if (isset($_POST['types']) && ($_POST['types'] != "")) {
                    $sql = "SELECT saleorders.*, saleorder_details.amount, garbages.garbage_name, garbages.garbage_types_id , garbage_types.type_name
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         INNER JOIN garbages ON (garbages.id = saleorder_details.garbages_id) 
                         INNER JOIN garbage_types ON (garbage_types.id = garbages.garbage_types_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND garbage_types.id = :types
                         AND closed_timestamp BETWEEN :date_from AND :date_to";

                    $sql .= " GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                    //die($sql);
                    $dataProvider = new \yii\data\SqlDataProvider([
                        'sql' => $sql,
                        //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                        'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to, ':types' => $_POST['types']],
                    ]);
                } else if ($_POST['status'] == 'open') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND post_timestamp BETWEEN :date_from AND :date_to";

                    $sql .= " GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                    //die($sql);
                    $dataProvider = new \yii\data\SqlDataProvider([
                        'sql' => $sql,
                        //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                        'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                    ]);
                } else if ($_POST['status'] == 'closed') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to";

                    $sql .= " GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                    //die($sql);
                    $dataProvider = new \yii\data\SqlDataProvider([
                        'sql' => $sql,
                        //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                        'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                    ]);
                } else if ($_POST['status'] == 'reserve') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND reserve_timestamp BETWEEN :date_from AND :date_to";

                    $sql .= " GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                    //die($sql);
                    $dataProvider = new \yii\data\SqlDataProvider([
                        'sql' => $sql,
                        //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                        'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                    ]);
                } else if ($_POST['status'] == 'cancel') {
                    $sql = "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         WHERE buyers = :id
                         AND saleorders.status IN (:status)
                         AND closed_timestamp BETWEEN :date_from AND :date_to";

                    $sql .= " GROUP BY saleorders.id  ORDER BY saleorders.id DESC";

                    //die($sql);
                    $dataProvider = new \yii\data\SqlDataProvider([
                        'sql' => $sql,
                        //'params' => [':id'=> Yii::$app->user->identity->id,':status' => $_POST['status'], ':date_from' => $_POST['date_from'], ':date_to' => $_POST['date_to']],
                        'params' => [':id' => Yii::$app->user->identity->id, ':status' => $_POST['status'], ':date_from' => $date_from, ':date_to' => $date_to],
                    ]);
                }




                return $this->render('buyer', [
                            'dataProvider' => $dataProvider,
                            'post' => TRUE,
                            'status' => $_POST['status'],
                            'date_from' => $date_from, //$_POST['date_from'],
                            'date_to' => $date_to, // $_POST['date_to'],
                            'type_report' => $_POST['types']
                ]);
            } else {
                return $this->render('buyer', [
                            'post' => false,
                            'type_report' => false
                ]);
            }
        } else {
            return $this->render('buyer', [
                        'post' => false,
                        'type_report' => false
            ]);
        }
    }

}
