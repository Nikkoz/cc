<?php

namespace backend\forms;


use core\entities\Blog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class BlogSearch
 * @package backend\forms
 *
 * @property string $title
 * @property integer $coin_id
 */
class BlogSearch extends Model
{
    public $coin_id;
    public $title;

    public function rules(): array
    {
        return [
            ['coin_id', 'integer'],
            ['title', 'string', 'max' => 255]
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Blog::find()->with('coin');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['=', 'coin_id', $this->coin_id]);

        return $dataProvider;
    }
}