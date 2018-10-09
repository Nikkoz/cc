<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.08.2018
 * Time: 9:14
 */

namespace backend\forms;


use core\entities\Coupons;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CouponsSearch
 * @package backend\forms
 *
 * @property string $code
 * @property integer $type
 * @property integer $publish
 */
class CouponsSearch extends Model
{
    public $code;
    public $type;
    public $publish;

    public function rules(): array
    {
        return [
            ['code', 'string'],
            [['type', 'publish'], 'integer']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Coupons::find();
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

        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['=', 'type', $this->type]);
        $query->andFilterWhere(['=', 'publish', $this->publish]);

        return $dataProvider;
    }
}