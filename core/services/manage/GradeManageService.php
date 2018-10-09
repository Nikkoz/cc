<?php

namespace core\services\manage;

use core\entities\manage\Grade;
use core\repositories\manage\GradeRepository;

/**
 * Class GradeManageService
 * @package core\services\manage\posts
 *
 * @property GradeRepository $repository
 */
class GradeManageService
{
    private $repository;

    public function __construct(GradeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(): Grade
    {

    }

    public function edit(): void
    {

    }

    public function remove(int $id): void
    {
        $grade = $this->repository->get($id);
        $this->repository->remove($grade);
    }
}