<?php

namespace core\entities\queries;


use core\entities\Sites;
use yii\db\ActiveQuery;

class SitesQuery extends ActiveQuery
{
    /**
     * @param string|null $alias
     * @return SitesQuery
     */
    public function active(string $alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'publish' => Sites::STATUS_ACTIVE,
        ]);
    }
}