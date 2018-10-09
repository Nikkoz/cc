<?php

namespace core\repositories;


use core\entities\Sites;

class SitesRepository
{
    public function get(int $id): Sites
    {
        if(!$site = Sites::findOne($id)) {
            throw new \DomainException('Site is not found.');
        }

        return $site;
    }

    public function save(Sites $site): void
    {
        if(!$site->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Sites $site): void
    {
        if(!$site->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}