<?php

namespace backend\forms;


use core\entities\Exchanges;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExchangesSearch extends Model
{
    public $name;
    public $type;

    public function rules(): array
    {
        return [
            ['name', 'string'],
            ['type', 'integer'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Exchanges::find()->with('network', 'user');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['=', 'type', $this->type]);

        return $dataProvider;
    }
}