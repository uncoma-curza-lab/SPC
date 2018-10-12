<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cargo;

/**
 * CargoSearch represents the model behind the search form of `backend\models\Cargo`.
 */
class CargoSearch extends Cargo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'persona_id', 'programa_id'], 'integer'],
            [['designacion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Cargo::find();

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
            'persona_id' => $this->persona_id,
            'programa_id' => $this->programa_id,
        ]);

        $query->andFilterWhere(['like', 'designacion', $this->designacion]);

        return $dataProvider;
    }
}
