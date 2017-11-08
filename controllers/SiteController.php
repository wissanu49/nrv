<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Saleorders;
use yii\data\SqlDataProvider;
use yii\db\Query;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'error'],
                'rules' => [
                    [
                        'actions' => ['index','error','logout', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                        /*
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'admin' || Yii::$app->user->identity->role === 'buyer' || Yii::$app->user->identity->role === 'seller') {
                                return true;
                            }
                            return false;
                        },
                         * */
                         
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (Yii::$app->user->identity->role == "manager") {
            return $this->redirect('reports/index');
        } else if (Yii::$app->user->identity->role == "seller") {
            return $this->redirect('saleorders/index');
        } else {
            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT saleorders.*, COUNT(saleorder_details.id) AS amount  
                         FROM saleorders 
                         INNER JOIN saleorder_details ON (saleorders.id = saleorder_details.saleorders_id) 
                         AND saleorders.status IN ('open')
                         GROUP BY saleorders.id
                         ORDER BY saleorders.id DESC",
            ]);


            $users = \app\models\Users::find()
                    //->select(['firstname','lastname','address','sub_district','district','province','lattitude','longitude'])
                    ->join('LEFT JOIN', 'saleorders', $on = 'users.id = saleorders.users_id')
                    ->where('users.id = saleorders.users_id')
                    ->andWhere("saleorders.status NOT IN ('closed','cancel')")
                    ->all();



            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'users' => $users,
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {

        Yii::$app->user->logout();
        yii::$app->session->destroy();
        return $this->goHome();
    }

}
