<?php

namespace core\repositories\algorithm;


use core\entities\algorithms\Encryption;

class EncryptionRepository
{
    public function get(int $id): Encryption
    {
        if(!$encryption = Encryption::findOne($id)) {
            throw new \DomainException('Algorithm encryption is not found.');
        }

        return $encryption;
    }

    public function save(Encryption $encryption): void
    {
        if(!$encryption->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Encryption $encryption): void
    {
        if(!$encryption->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}