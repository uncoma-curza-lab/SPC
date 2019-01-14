<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Asignatura;

/**
 * AsignaturaSearch represents the model behind the search form of `backend\models\Asignatura`.
 */
class AsignaturaSearch extends Asignatura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'curso', 'cuatrimestre', 'carga_horaria_sem', 'carga_horaria_cuatr', 'plan_id', 'departamento_id'], 'integer'],
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
        $query = Asignatura::find();

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
            'curso' => $this->curso,
		        'cuatrimestre' => $this->cuatrimestre, 
		        'carga_horaria_sem' => $this->carga_horaria_sem,
		        'carga_horaria_cuatr' => $this->carga_horaria_cuatr,
            'departamento_id' => $this->departamento_id,
            'plan_id' => $this->plan_id,
        ]);

        $query->andFilterWhere(['like', 'nomenclatura', $this->nomenclatura]);

        return $dataProvider;
    }
}
