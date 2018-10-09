<?php

namespace core\repositories\coins;


use core\entities\coins\handbook\Handbook;

class HandbookRepository
{
    public function get($id): Handbook
    {
        if(!$handbook = Handbook::findOne($id)) {
            throw new \DomainException('Handbook is not found.');
        }

        return $handbook;
    }

    public function getBy(array $conditions): array
    {
        if(!$words = Handbook::find()->andWhere($conditions)->all()) {
            throw new \DomainException('Handbook words are not found.');
        }
        return $words;
    }

    public function save(Handbook $handbook): void
    {
        if(!$handbook->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Handbook $handbook): void
    {
        if(!$handbook->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}