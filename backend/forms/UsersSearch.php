<?php

namespace backend\forms;


use core\entities\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class UsersSearch
 * @package backend\forms
 *
 * @property string $name
 * @property string $email
 * @property string $role
 */
class UsersSearch extends Model
{
    public $email;
    public $name;
    public $role;

    public function rules(): array
    {
        return [
            [['email', 'name', 'role'], 'string', 'max' => 255]
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = User::find();

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
        $query->andFilterWhere(['like', 'email', $this->email]);


        return $dataProvider;
    }
}