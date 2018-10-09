<?php

namespace backend\forms\posts;


use core\entities\parse\Posts;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostsSearch extends Model
{
    public $title;

    public function rules(): array
    {
        return [
            [['title'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Posts::find()->where(['type' => 'post'])->with('handbooks', 'site');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created' => SORT_DESC]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}