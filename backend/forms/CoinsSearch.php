<?php
namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\coins\Coins;

class CoinsSearch extends Model
{
    public $name;
    public $type;

    public function rules(): array
    {
        return [
            ['type', 'integer'],
            ['name', 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Coins::find()->with('user', 'assignmentsSocials');
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