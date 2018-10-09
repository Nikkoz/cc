<?php

namespace backend\forms;


use core\entities\Seo;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SeoSearch
 * @package backend\forms
 *
 * @property string $name
 * @property string $alias
 */
class SeoSearch extends Model
{
    public $name;
    public $alias;

    public function rules(): array
    {
        return [
            [['name', 'alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Seo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}