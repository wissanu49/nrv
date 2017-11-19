<?php
namespace app\controllers;

use app\models\DepdropThailand;
use app\models\District;
use app\models\Province;
use app\models\Subdistrict;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class DepdropThailandController extends Controller
{
    public function actionIndex()
    {
        $model = new DepdropThailand();

        if($model->load(Yii::$app->request->post())){
            var_dump($model);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
    
    public function actionProvinceList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region_id = $parents[0];
                foreach(Province::find()->where(['region_id' => $region_id])->orderBy(['name' => SORT_ASC])->all() as $province){
                    $out[] = ['id' => $province->id, 'name' => $province->name];
                }

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
      
     

    public function actionDistrictList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            //var_dump($parents);
            if ($parents != null) {
                $province_id = $parents[0];
                foreach(District::find()->where(['province_id' => $province_id])->orderBy(['name' => SORT_ASC])->all() as $district){
                    $out[] = ['id' => $district->id, 'name' => $district->name];
                }

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionSubdistrictList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $subdistrict_id = $parents[0];
                foreach(Subdistrict::find()->where(['district_id' => $subdistrict_id])->orderBy(['name' => SORT_ASC])->all() as $subdistrict){
                    $out[] = ['id' => $subdistrict->id, 'name' => $subdistrict->name];
                }

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}