<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NotificationPanel;

/**
 * RolSearch represents the model behind the search form about `common\models\Rol`.
 */
class NotificationUserSearch extends NotificationPanel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_receiver','user_init'], 'integer'],
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
        $userId = \Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['=','user_receiver',$userId]);
        $query->andFilterWhere([
            'id' => $this->id,
            'user_receiver' => $this->user_receiver,
            'user_init' => $this->user_init
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);
            

        return $dataProvider;
    }
}
