<?php

namespace core\repositories;


use core\entities\Exchanges;

class ExchangesRepository
{
    public function get(int $id): Exchanges
    {
        if(!$exchanges = Exchanges::findOne($id)) {
            throw new \DomainException('Exchanges is not found.');
        }

        return $exchanges;
    }

    public function save(Exchanges $exchanges): void
    {
        if(!$exchanges->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Exchanges $exchanges): void
    {
        if(!$exchanges->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}