<?php

namespace backend\forms\posts;


use core\entities\coins\Coins;
use core\entities\parse\Twitter;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TwitterSearch
 * @package backend\forms\posts
 *
 * @property int $coin_id
 * @property string $text
 */
class TwitterSearch extends Model
{
    public $text;
    public $coin_id;

    public function rules(): array
    {
        return [
            ['coin_id', 'integer'],
            [['text'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Twitter::find()->where(['type' => 'twitter'])->with('coin', 'handbooks');

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

        $query->andFilterWhere(['like', 'text', $this->text]);

        if(!empty($this->coin_id)) {
            $query->andFilterWhere(['coin_id' => $this->coin_id]);
            /*$query->leftJoin(Coins::tableName() . " coins","coins.id = coin_id")
                ->andFilterWhere(['like', 'coins.name', $this->coin_id]);*/
        }

        return $dataProvider;
    }
}