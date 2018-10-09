<?php

namespace core\services\manage\landing;


use core\forms\manage\landing\blocks\BlocksForm;
use core\repositories\landing\BlocksRepository;

/**
 * Class BlocksManageService
 * @package core\services\manage\landing
 *
 * @property BlocksRepository $repository
 */
class BlocksManageService
{
    private $repository;

    public function __construct(BlocksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function edit(int $id, \core\forms\manage\landing\blocks\BlocksForm $form): void
    {
        $block = $this->repository->get($id);

        $block->edit($form->phrase_one, $form->phrase_two, $form->phrase_three);

        $this->repository->save($block);
    }
}