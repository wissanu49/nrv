<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Garbages;

/**
 * GarbagesSearch represents the model behind the search form about `app\models\Garbages`.
 */
class GarbagesSearch extends Garbages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'garbage_types_id', 'units_id'], 'integer'],
            [['garbage_name'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Garbages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'garbage_types_id' => $this->garbage_types_id,
            'units_id' => $this->units_id,
        ]);

        $query->andFilterWhere(['like', 'garbage_name', $this->garbage_name]);

        return $dataProvider;
    }
}
