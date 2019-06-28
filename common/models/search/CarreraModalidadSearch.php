<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CarreraModalidad;

/**
 * CorrelativaSearch represents the model behind the search form of `common\models\Correlativa`.
 */
class CarreraModalidadSearch extends CarreraModalidad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'carrera_id', 'modalidad_id'], 'integer'],
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
        $query = CarreraModalidad::find();

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
            'carrera_id' => $this->carrera_id,
            'modalidad_id' => $this->modalidad_id,
        ]);

        return $dataProvider;
    }
}
