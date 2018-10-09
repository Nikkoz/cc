<?php

namespace core\repositories\coins\socials;

use core\entities\coins\socials\Socials;

class SocialsRepository
{
    public function get(int $id): Socials
    {
        if (!$coin = Socials::findOne($id)) {
            throw new \DomainException('Social is not found.');
        }

        return $coin;
    }

    public function save(Socials $coin): void
    {
        if (!$coin->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Socials $coin): void
    {
        if (!$coin->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}