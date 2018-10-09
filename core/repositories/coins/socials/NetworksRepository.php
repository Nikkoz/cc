<?php

namespace core\repositories\coins\socials;

use core\entities\coins\socials\Networks;

class NetworksRepository
{
    public function get(int $id): Networks
    {
        if (!$coin = Networks::findOne($id)) {
            throw new \DomainException('Network is not found.');
        }

        return $coin;
    }

    public function save(Networks $coin): void
    {
        if (!$coin->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Networks $coin): void
    {
        if (!$coin->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}