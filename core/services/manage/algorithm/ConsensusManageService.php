<?php

namespace core\services\manage\algorithm;

use core\entities\algorithms\Consensus;
use core\forms\manage\algorithm\ConsensusForm;
use core\repositories\algorithm\ConsensusRepository;

/**
 * Class ConsensusManageService
 * @package core\services\manage\algorithm
 *
 * @property ConsensusRepository $repository
 */
class ConsensusManageService
{
    private $repository;

    public function __construct(ConsensusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ConsensusForm $form): Consensus
    {
        $consensus = Consensus::create($form->name);
        $this->repository->save($consensus);

        return $consensus;
    }

    public function edit(int $id, ConsensusForm $form): void
    {
        $consensus = $this->repository->get($id);
        $consensus->edit($form->name);

        $this->repository->save($consensus);
    }

    public function remove(int $id): void
    {
        $consensus = $this->repository->get($id);
        $this->repository->remove($consensus);
    }
}