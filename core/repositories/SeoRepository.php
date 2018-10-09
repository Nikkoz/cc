<?php

namespace core\repositories;


use core\entities\Seo;

class SeoRepository
{
    public function get(int $id): Seo
    {
        if(!$seo = Seo::findOne($id)) {
            throw new \DomainException('Seo is not found.');
        }

        return $seo;
    }

    public function save(Seo $seo): void
    {
        if(!$seo->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Seo $seo): void
    {
        if(!$seo->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}