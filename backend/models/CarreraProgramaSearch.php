<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CarreraPrograma;

/**
 * CarreraProgramaSearch represents the model behind the search form of `backend\models\CarreraPrograma`.
 */
class CarreraProgramaSearch extends CarreraPrograma
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'carrera_id', 'programa_id'], 'integer'],
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
        $query = CarreraPrograma::find();

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
            'carrera_id' => $this->carrera_id,
            'programa_id' => $this->programa_id,
        ]);

        return $dataProvider;
    }
}
