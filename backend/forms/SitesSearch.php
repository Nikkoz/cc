<?php

namespace backend\forms;


use core\entities\Sites;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SitesSearch
 * @package backend\forms
 *
 * @property string $name
 * @property integer $publish
 */
class SitesSearch extends Model
{
    public $name;
    public $publish;

    public function rules(): array
    {
        return [
            [['name', 'publish'], 'safe']
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Sites::find();

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

        $query->andFilterWhere(['=', 'publish', $this->publish]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}