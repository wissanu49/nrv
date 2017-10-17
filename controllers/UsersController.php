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
/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','update','delete','create','uploadimg'],
                'rules' => [
                    [
                        'actions' => ['index','update','delete','create','uploadimg'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['signup'],
                        'roles' => ['?','@'],
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUploadimg($id){
        
        $model = $this->findModel($id);
        $model->setScenario('upImage'); 

        if($model->load(Yii::$app->request->post())){
            try{
                    $model->image = UploadedFile::getInstance($model, 'image');
                    $model->image = $model->uploadImage(); //method return ชื่อไฟล์
                    //var_dump($model->image);
                    //die();
                    $model->save();//บันทึกข้อมูล
                    //var_dump($model);
                    //die();
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['users/update', 'id' => $model->id]);
               
            }catch(Exception $e){
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNewAccount()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreate()
    {
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
    
    public function actionSignup()
    {
        $model = new Users();
        
        $this->layout = 'main-login';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['login']);
        } else {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $model->setScenario('updateProfile'); 
        
        try{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } catch (Exception $e){
            
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
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
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
