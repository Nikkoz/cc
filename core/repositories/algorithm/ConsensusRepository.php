<?php

namespace core\repositories\algorithm;


use core\entities\algorithms\Consensus;

class ConsensusRepository
{
    public function get(int $id): Consensus
    {
        if (!$encryption = Consensus::findOne($id)) {
            throw new \DomainException('Algorithm consensus is not found.');
        }

        return $encryption;
    }

    public function save(Consensus $consensus): void
    {
        if (!$consensus->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Consensus $consensus): void
    {
        if (!$consensus->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}