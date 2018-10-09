<?php

namespace core\repositories\manage;


use core\entities\manage\Duplicate;

class DuplicateRepository
{
    public function get(int $id): Duplicate
    {
        if (!$duplicate = Duplicate::findOne($id)) {
            throw new \DomainException('Duplicate is not found.');
        }

        return $duplicate;
    }

    public function save(Duplicate $duplicate): void
    {
        if (!$duplicate->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Duplicate $duplicate): void
    {
        if (!$duplicate->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}