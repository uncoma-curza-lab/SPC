<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Programa;

/**
 * ProgramaSearch represents the model behind the search form of `backend\models\Programa`.
 */
class ProgramaSearch extends Programa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departamento_id', 'status_id', 'asignatura_id', 'year', 'created_by', 'updated_by'], 'integer'],
            [[ 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur', 'created_at', 'updated_at'], 'safe'],
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
        $query = Programa::find();

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
            'departamento_id' => $this->departamento_id,
            'status_id' => $this->status_id,
            'asignatura_id' => $this->asignatura_id,
            'year' => $this->year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'fundament', $this->fundament])
            ->andFilterWhere(['like', 'objetivo_plan', $this->objetivo_plan])
            ->andFilterWhere(['like', 'contenido_plan', $this->contenido_plan])
            ->andFilterWhere(['like', 'propuesta_met', $this->propuesta_met])
            ->andFilterWhere(['like', 'evycond_acreditacion', $this->evycond_acreditacion])
            ->andFilterWhere(['like', 'parcial_rec_promo', $this->parcial_rec_promo])
            ->andFilterWhere(['like', 'distr_horaria', $this->distr_horaria])
            ->andFilterWhere(['like', 'crono_tentativo', $this->crono_tentativo])
            ->andFilterWhere(['like', 'actv_extracur', $this->actv_extracur]);

        return $dataProvider;
    }
}
