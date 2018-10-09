<?php

namespace core\services\manage;


use core\entities\manage\Duplicate;
use core\repositories\manage\DuplicateRepository;

/**
 * Class DuplicateManageService
 * @package core\services\manage
 *
 * @property DuplicateRepository $repository
 */
class DuplicateManageService
{
    private $repository;

    public function __construct(DuplicateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(): Duplicate
    {

    }

    public function edit(): void
    {

    }

    public function remove(int $id): void
    {
        $duplicate = $this->repository->get($id);
        $this->repository->remove($duplicate);
    }
}