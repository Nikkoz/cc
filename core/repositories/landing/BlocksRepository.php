<?php

namespace core\repositories\landing;


use core\entities\landing\Blocks;

class BlocksRepository
{
    public function get(int $id): Blocks
    {
        if (!$block = Blocks::findOne($id)) {
            throw new \DomainException('Block is not found.');
        }

        return $block;
    }

    public function save(Blocks $block): void
    {
        if (!$block->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Blocks $block): void
    {
        if (!$block->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}