<?php

namespace core\entities\queries;


use core\entities\coins\Coins;
use yii\db\ActiveQuery;

class CoinsQuery extends ActiveQuery
{
    /**
     * @param string|null $alias
     * @return CoinsQuery
     */
    public function active(string $alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'publish' => Coins::STATUS_ACTIVE,
        ]);
    }
}