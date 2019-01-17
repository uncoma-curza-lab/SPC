<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Programa;
use frontend\models\Perfil;
use common\models\PermisosHelpers;
use common\models\User;

/**
 * ProgramaSearch represents the model behind the search form of `backend\models\Programa`.
 */
class ProgramaSearch extends Programa
{
    public function attributes(){
        return array_merge(parent::attributes(),['user.username']);
    }

    public function attributeLabels(){
        return array_merge(parent::attributeLabels(),['user.username'=>'nombre de usuario']);
    }
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
        $esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
        $userId = \Yii::$app->user->identity->id;
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

        //$query->joinWith('user');
        /*$query->andFilterWhere(
            ['LIKE','user.username',$this->getAttribute('user.username')]
        );*/

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

        if(!$esAdmin){
          if (PermisosHelpers::requerirRol('Departamento')){
            $depto = Departamento::find()->where(['=','director',$userId])->one();

            //$perfil = \Yii::$app->user->identity->perfil;
            if (isset($depto)){
              //if($perfil->departamento_id != 2) {
              $query->joinWith(['asignatura']);
              $query->andFilterWhere(['=','asignatura.departamento_id', $depto->id])->all();
              //  }
            } else {
                $query->joinWith(['asignatura']);
                $query->andFilterWhere(['=','asignatura.departamento_id',-1 ])->all();
            }
          } else if (PermisosHelpers::requerirRol('Profesor')) {
            $query->joinWith(['designaciones']);
            $cargo = Cargo::find()->where(['=','carga_programa',1])->one();
            $query->andFilterWhere(['=','designacion.cargo_id',$cargo->id])->andFilterWhere(['=','designacion.user_id',$userId]);

          }else if (PermisosHelpers::requerirRol('Usuario')) {
            $query->joinWith(['status']);
            $query->andFilterWhere(['like','status.descripcion', 'publicado']);
          }
        }

        $query->andFilterWhere(['like', 'fundament', $this->fundament])
        //->andFilterWhere(['like', 'asignatura', $this->asignatura])
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
