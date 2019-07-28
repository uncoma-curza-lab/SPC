<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TituloIntermedio;

/**
 * CorrelativaSearch represents the model behind the search form of `common\models\Correlativa`.
 */
class TituloIntermedioSearch extends TituloIntermedio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'carrera_id', 'titulo_intermedio_id'], 'integer'],
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
        $query = TituloIntermedio::find();

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
            'titulo_intermedio_id' => $this->titulo_intermedio_id,
        ]);

        return $dataProvider;
    }
}
