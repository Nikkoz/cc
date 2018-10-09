<?php

namespace backend\forms\manage;


use core\entities\manage\Grade;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class GradeSearch
 * @package backend\forms\posts
 *
 * @property int $vote_type
 */
class GradeSearch extends Model
{
    public $vote_type;

    public function rules(): array
    {
        return [
            ['vote_type', 'integer']
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Grade::find()->with('user', 'post');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        if(!empty($this->vote_type)) {
            switch($this->vote_type) {
                case 0:
                    $query->andFilterWhere(['vote_type'=>'like','vote_val'=>'Y']);
                    break;
                case 1:
                    $query->andFilterWhere(['vote_type'=>'like','vote_val'=>'N']);
                    break;
                case 2:
                    $query->andFilterWhere(['vote_type'=>'growth','vote_val'=>'Y']);
                    break;
                case 3:
                    $query->andFilterWhere(['vote_type'=>'growth','vote_val'=>'N']);
                    break;
                case 4:
                    $query->andFilterWhere(['vote_type'=>'important','vote_val'=>'Y']);
                    break;
                case 5:
                    $query->andFilterWhere(['vote_type'=>'important','vote_val'=>'N']);
                    break;
                case 6:
                    $query->andFilterWhere(['vote_type'=>'toxic','vote_val'=>'Y']);
                    break;
                case 7:
                    $query->andFilterWhere(['vote_type'=>'save','vote_val'=>'Y']);
                    break;
            }
        }

        return $dataProvider;
    }
}