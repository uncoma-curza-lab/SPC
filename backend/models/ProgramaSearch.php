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
            [['id',  'status_id', 'cuatrimestre', 'created_by', 'updated_by'], 'integer'],
        //    [['asignatura', 'curso', 'year', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s', 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur', 'created_at', 'updated_at'], 'safe'],
           [['asignatura', 'curso', 'year', 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur', 'created_at', 'updated_at'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('user');

        $query->andFilterWhere(
                ['LIKE','user.username',$this->getAttribute('user.username')]
        );

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
            'cuatrimestre' => $this->cuatrimestre,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if(!$esAdmin){ //si no es admin refuerza el user id con el usuario logueado
          if (PermisosHelpers::requerirRol('Departamento')){
            $perfil = \Yii::$app->user->identity->perfil;
            if($perfil->departamento_id != 2) {
              $query->joinWith(['carreras']);
              $query->andFilterWhere(['=','carrera.departamento_id', $perfil->departamento_id])->all();
            }
          } else if (PermisosHelpers::requerirRol('Profesor')) {
            $query->andFilterWhere([
                'created_by' => $userId,
            ]);
          }else if (PermisosHelpers::requerirRol('Usuario')) {
            $query->joinWith(['status']);
            $query->andFilterWhere(['like','status.descripcion', 'publicado']);
          }
        }
        $query->andFilterWhere(['like', 'asignatura', $this->asignatura])
            ->andFilterWhere(['like', 'curso', $this->curso])
            ->andFilterWhere(['like', 'year', $this->year])
        //    ->andFilterWhere(['like', 'profadj_regular', $this->profadj_regular])
          //  ->andFilterWhere(['like', 'asist_regular', $this->asist_regular])
          //  ->andFilterWhere(['like', 'ayudante_p', $this->ayudante_p])
          //  ->andFilterWhere(['like', 'ayudante_s', $this->ayudante_s])
            ->andFilterWhere(['like', 'fundament', $this->fundament])
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
