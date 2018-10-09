<?php

namespace core\services\manage\algorithm;

use core\entities\algorithms\Encryption;
use core\forms\manage\algorithm\EncryptionForm;
use core\repositories\algorithm\EncryptionRepository;

/**
 * Class EncryptionManageService
 * @package core\services\manage\algorithm
 *
 * @property EncryptionRepository $repository
 */
class EncryptionManageService
{
    private $repository;

    public function __construct(EncryptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(EncryptionForm $form): Encryption
    {
        $encryption = Encryption::create($form->name);
        $this->repository->save($encryption);

        return $encryption;
    }

    public function edit(int $id, EncryptionForm $form): void
    {
        $encryption = $this->repository->get($id);
        $encryption->edit($form->name);

        $this->repository->save($encryption);
    }

    public function remove(int $id): void
    {
        $encryption = $this->repository->get($id);
        $this->repository->remove($encryption);
    }
}