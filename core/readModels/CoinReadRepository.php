<?php

namespace core\readModels;


use core\entities\coins\Coins;

class CoinReadRepository
{
    public function find(int $id): ?Coins
    {
        return Coins::findOne($id);
    }

    public function findActiveByCode(string $code): ?Coins
    {
        return Coins::findOne(['alias' => $code, 'publish' => Coins::STATUS_ACTIVE]);
    }

    public function findActiveById(int $id): ?Coins
    {
        return Coins::findOne(['id' => $id, 'publish' => Coins::STATUS_ACTIVE]);
    }
}