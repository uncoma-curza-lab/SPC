<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cargo;

/**
 * CargoSearch represents the model behind the search form of `common\models\Cargo`.
 */
class CargoSearch extends Cargo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'carga_programa'], 'integer'],
            [['nomenclatura'], 'safe'],
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
            'carga_programa' => $this->carga_programa,
        ]);

        $query->andFilterWhere(['like', 'nomenclatura', $this->nomenclatura]);

        return $dataProvider;
    }
}
