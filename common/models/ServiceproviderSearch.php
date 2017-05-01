<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Serviceprovider;

/**
 * ServiceproviderSearch represents the model behind the search form about `\common\models\Serviceprovider`.
 */
class ServiceproviderSearch extends Serviceprovider
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'country_id', 'category_id'], 'integer'],
            [['name', 'address', 'address2', 'email', 'website', 'keywords', 'phone', 'mobile', 'services'], 'safe'],
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
        $query = Serviceprovider::find();

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
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'services', $this->services]);

        return $dataProvider;
    }
}
