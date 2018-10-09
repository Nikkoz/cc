<?php

namespace core\entities\queries;


use core\entities\coins\handbook\Handbook;
use yii\db\ActiveQuery;

class HandbookQuery extends ActiveQuery
{
    /**
     * @param string|null $alias
     * @return HandbookQuery
     */
    public function active(string $alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'publish' => Handbook::STATUS_ACTIVE,
        ]);
    }
}