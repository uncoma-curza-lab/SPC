<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NotificationPanel;

/**
 * RolSearch represents the model behind the search form about `common\models\Rol`.
 */
class NotificationPanelSearch extends NotificationPanel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','receiver_user','init_user'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = NotificationPanel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'receiver_user' => $this->receiver_user,
            'init_user' => $this->init_user
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
            

        return $dataProvider;
    }
}
