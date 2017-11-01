<?php
namespace app\controllers; 

use Yii;
use yii\models\DepdropGarbageTypes;
use app\models\Garbages;
use yii\helpers\Json;
use yii\web\Controller;

class DepDropController extends Controller
{
    public function actionIndex()
    {
        $model = new MyDepDrop();

        if($model->load(Yii::$app->request->post())){
            var_dump($model);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

   
    public function actionGarbagestList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $type_id = $parents[0];
                foreach(\app\models\GarbageTypes::find()->where(['id' => $type_id])->orderBy(['id' => SORT_ASC])->all() as $garbagetypes){
                    $out[] = ['id' => $garbagetypes->id, 'name' => $garbagetypes->type_name];
                }

                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    
}