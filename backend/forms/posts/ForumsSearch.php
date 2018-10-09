<?php

namespace backend\forms\posts;


use core\entities\parse\ForumMessages;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ForumsSearch
 * @package backend\forms\posts
 *
 * @property string $text
 */
class ForumsSearch extends Model
{
    public $text;

    public function rules(): array
    {
        return [
            ['text', 'string'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = ForumMessages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}