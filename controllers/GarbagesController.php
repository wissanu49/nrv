<?php

namespace app\controllers;

use Yii;
use app\models\Garbages;
use app\models\GarbagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GarbagesController implements the CRUD actions for Garbages model.
 */
class GarbagesController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'create'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'admin') {
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
     * Lists all Garbages models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new GarbagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Garbages model.
     * @param integer $id
     * @param integer $units_id
     * @return mixed
     */
    public function actionView($id, $units_id) {
        return $this->render('view', [
                    'model' => $this->findModel($id, $units_id),
        ]);
    }

    /**
     * Creates a new Garbages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Garbages();
        $model->setScenario('create');
        $transection = \Yii::$app->db->transaction;
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->garbagelastID = $model->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                //$transection->commit();
                //return $this->redirect(['view', 'id' => $model->id, 'units_id' => $model->units_id]);
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                //$transection->rollBack();
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Garbages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $units_id
     * @return mixed
     */
    public function actionUpdate($id, $units_id) {
        $model = $this->findModel($id, $units_id);
        $transection = Yii::$app->db->transaction;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $transection->commit();

                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                //return $this->redirect(['view', 'id' => $model->id, 'units_id' => $model->units_id]);
                return $this->redirect(['garbages/index']);
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                $transection->rollBack();
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Garbages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $units_id
     * @return mixed
     */
    public function actionDelete($id, $units_id) {
        $transection = \Yii::$app->db->transaction;

        if ($this->findModel($id, $units_id)->delete()) {
            Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
            $transection->commit();
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            $transection->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Garbages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $units_id
     * @return Garbages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $units_id) {
        if (($model = Garbages::findOne(['id' => $id, 'units_id' => $units_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
