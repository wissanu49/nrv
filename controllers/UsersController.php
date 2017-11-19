<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\District;
use app\models\Province;
use app\models\Subdistrict;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create', 'uploadimg', 'changepwd', 'districtlist', 'subdistrictlist'],
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'admin') {
                                return true;
                            }
                            return false;
                        },
                    ],
                    [
                        'actions' => ['update', 'uploadimg', 'changepwd'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['signup', 'districtlist', 'subdistrictlist'],
                        'roles' => ['?', '@'],
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

    public function actionDistrictlist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            //var_dump($parents);
            if ($parents != null) {
                $province_id = $parents[0];
                foreach (District::find()->where(['province_id' => $province_id])->orderBy(['name' => SORT_ASC])->all() as $district) {
                    $out[] = ['id' => $district->id, 'name' => $district->name];
                }

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDistrict($id) {
        $datas = District::find()->where(['province_id' => $id])->all();
        return $this->MapData($datas, 'id', 'name');
    }
    
    protected function getSubDistrict($id) {
        $datas = Subdistrict::find()->where(['district_id' => $id])->all();
        return $this->MapData($datas, 'id', 'name');
    }
 
    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionSubdistrictlist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $subdistrict_id = $parents[0];
                foreach (Subdistrict::find()->where(['district_id' => $subdistrict_id])->orderBy(['name' => SORT_ASC])->all() as $subdistrict) {
                    $out[] = ['id' => $subdistrict->id, 'name' => $subdistrict->name];
                }

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUploadimg($id) {

        $model = $this->findModel($id);
        $model->setScenario('upImage');

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->image = $model->uploadImage(); //method return ชื่อไฟล์
                //var_dump($model->image);
                //die();
                $model->save(); //บันทึกข้อมูล
                //var_dump($model);
                //die();
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                return $this->redirect(['users/update', 'id' => $model->id]);
            } catch (Exception $e) {
                Yii::$app->session->setFlash('danger', 'เกิดข้อผิดพลาด');
                return $this->redirect(['users/update', 'id' => $model->id]);
            }
        }

        return $this->render('uploadimage', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNewAccount() {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreate() {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSignup() {
        $model = new Users();

        $this->layout = 'main-login';

        if ($model->load(Yii::$app->request->post())) {

            $model->image = UploadedFile::getInstance($model, 'image');
            $model->image = $model->uploadImage(); //method return ชื่อไฟล์
            if ($model->save()) {
                return $this->redirect(['login']);
            }
            return $this->render('signup', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('signup', [
                        'model' => $model,
            ]);
        }
    }

    public function actionChangepwd($id) {
        $model = new Users();
        $model = Users::findIdentity($id);
        $model->setScenario('changepwd');

        $password = $model->password;
        if ($model->load(Yii::$app->request->post())) {

            $model->password = \Yii::$app->security->generatePasswordHash($model->new_password);

            if ($model->save()) {

                \Yii::$app->session->setFlash('success', 'เปลี่ยนรหัสผ่านเรียบร้อย');
                return $this->render('update', [
                            'model' => $model,
                ]);
            } else {
                \Yii::$app->session->setFlash('erreo', 'เกิดข้อผิดพลาด เปลี่ยนรหัสผ่านไม่สำเร็จ');
                return $this->render('changepwd', [
                            'model' => $model,
                ]);
            }
        }
        return $this->render('changepwd', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);
        $model->setScenario('updateProfile');

        $district = ArrayHelper::map($this->getDistrict($model->province), 'id', 'name');
        $subdistrict = ArrayHelper::map($this->getSubDistrict($model->district), 'id', 'name');
        
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'district' => $district,
                            'subdistrict' => $subdistrict,
                ]);
            }
        } catch (Exception $e) {
            
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
