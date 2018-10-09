<?php

namespace core\services\manage;


use core\forms\manage\FormulaForm;
use core\repositories\FormulaRepository;

/**
 * Class FormulaManageService
 * @package core\services\manage
 *
 * @property FormulaRepository $repository
 */
class FormulaManageService
{
    private $repository;

    public function __construct(FormulaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function edit(int $id, FormulaForm $form): void
    {
        $formula = $this->repository->get($id);
        $formula->edit(
            $form->news_max_val,
            $form->news_max_count,
            $form->community_max_val,
            $form->community_max_count,
            $form->developers_max_val,
            $form->developers_max_count,
            $form->exchanges_max_val,
            $form->exchanges_max_count
        );

        $this->repository->save($formula);
    }

    public function remove(int $id): void
    {
        $formula = $this->repository->get($id);
        $this->repository->remove($formula);
    }
}