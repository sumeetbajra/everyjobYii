<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PostServices;

/**
 * PostSearch represents the model behind the search form about `app\models\PostServices`.
 */
class PostSearch extends PostServices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id', 'owner_id', 'max_active_orders', 'max_delivery_days', 'active'], 'integer'],
            [['description', 'price', 'image_url', 'expiry_date', 'datetimestamp'], 'safe'],
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
        $query = PostServices::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'post_id' => $this->post_id,
            'category_id' => $this->category_id,
            'owner_id' => $this->owner_id,
            'expiry_date' => $this->expiry_date,
            'datetimestamp' => $this->datetimestamp,
            'max_active_orders' => $this->max_active_orders,
            'max_delivery_days' => $this->max_delivery_days,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'image_url', $this->image_url]);

        return $dataProvider;
    }
}
