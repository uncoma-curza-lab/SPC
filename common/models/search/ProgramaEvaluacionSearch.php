<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Programa;
use frontend\models\Perfil;
use common\models\PermisosHelpers;
use common\models\Departamento;
use common\models\User;
use common\models\Cargo;
use common\models\Designacion;
use common\models\Status;
use yii\web\ForbiddenHttpException;

/**
 * ProgramaSearch represents the model behind the search form of `common\models\Programa`.
 */

class ProgramaEvaluacionSearch extends Programa
{
    public $departamento;
    public $perfil;
    public $asignatura;
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
            [[ //'asignatura',

            'departamento','fundament', 'objetivo_plan',
            'contenido_plan', 'propuesta_met', 'evycond_acreditacion',
            'parcial_rec_promo', 'distr_horaria', 'crono_tentativo',
            'actv_extracur', 'created_at', 'updated_at','perfil'], 'safe'],
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
        $perfil = \Yii::$app->user->identity->perfil;
        // si es director tiene una designación con ese cargo
        $cargoDirector = Cargo::find()->where(['=','nomenclatura','Director'])->one();
        if ($perfil){
          $designacion = Designacion::find()->where(['=','perfil_id',$perfil->id])->andWhere(['=','cargo_id',$cargoDirector->id])->one();
          $depto = null;
          if($designacion) {
            $depto = $designacion->departamento_id;
          }
        }

        if (!$depto) {
            throw new ForbiddenHttpException("No tiene acceso para listar los programas en evaluación.");
        }


        $query = Programa::find();
        $query->where(['not',['departamento_id' => null]]);
        if(PermisosHelpers::requerirRol("Departamento"))
          $query->where(['=','departamento_id',$depto]);
        else if (PermisosHelpers::requerirRol("Adm_academica") ){
          $statusAdm_academica = Status::find()->where(['=','descripcion','Administración Académica'])->one();
          $query->where(['=','status_id',$statusAdm_academica->id]);
        } else if(PermisosHelpers::requerirRol("Sec_academica")) {
          $statusSec_academica = Status::find()->where(['=','descripcion','Secretaría Académica'])->one();
          $query->where(['=','status_id',$statusSec_academica->id]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'year' => SORT_DESC,
                    'updated_at' => SORT_DESC
                ]
            ]
        ]);
        //$query->joinWith(['asignatura']);
        $query->joinWith(['departamento']);
        $query->joinWith(['perfil']);

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
        $query->joinWith(['status']);

        $query->andFilterWhere(['like', 'fundament', $this->fundament])
        //->andFilterWhere(['like', 'asignatura', $this->asignatura])
        ->andFilterWhere(['like', '{{%asignatura}}.nomenclatura', $this->asignatura])
        ->andFilterWhere(['like', '{{%departamento}}.nom', $this->departamento])
            ->andFilterWhere(['like', 'objetivo_plan', $this->objetivo_plan])
            ->andFilterWhere(['like', 'contenido_plan', $this->contenido_plan])
            ->andFilterWhere(['like', 'propuesta_met', $this->propuesta_met])
            ->andFilterWhere(['like', 'evycond_acreditacion', $this->evycond_acreditacion])
            ->andFilterWhere(['like', 'parcial_rec_promo', $this->parcial_rec_promo])
            ->andFilterWhere(['like', 'distr_horaria', $this->distr_horaria])
            ->andFilterWhere(['like', 'crono_tentativo', $this->crono_tentativo])
            ->andFilterWhere(['like', 'concat({{%perfil}}.nombre,{{%perfil}}.apellido)', $this->perfil])

            ->andFilterWhere(['like', 'actv_extracur', $this->actv_extracur]);


        return $dataProvider;
    }
}
