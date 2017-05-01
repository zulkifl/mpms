<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * CommunitySearch represents the model behind the search form about `common\models\Community`.
 */
class UserSearch extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['username', 'phone', 'c_timestamp',  'is_admin', 'email', 'f_name', 'l_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = User::find();

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
            'is_admin' => $this->is_admin,
            
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'f_name', $this->f_name])
                ->andFilterWhere(['like', 'l_name', $this->l_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'c_timestamp', $this->c_timestamp]);

        return $dataProvider;
    }

}
