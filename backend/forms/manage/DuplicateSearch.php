<?php

namespace backend\forms\manage;


use core\entities\manage\Duplicate;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DuplicateSearch extends Model
{
    public function search(array $params): ActiveDataProvider
    {
        $query = Duplicate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['time_up' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        //filter conditions

        return $dataProvider;
    }
}