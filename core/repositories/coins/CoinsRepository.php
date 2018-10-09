<?php
namespace core\repositories\coins;

use core\entities\coins\Coins;

class CoinsRepository
{
    public function get(int $id): Coins
    {
        if(!$coin = Coins::findOne($id)) {
            throw new \DomainException('Coin is not found.');
        }

        return $coin;
    }

    public function save(Coins $coin): void
    {
        if(!$coin->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Coins $coin): void
    {
        if(!$coin->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}