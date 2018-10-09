<?php

namespace core\services\manage;

use core\entities\coins\socials\Networks;
use core\forms\manage\coins\socials\NetworksForm;
use core\repositories\coins\socials\NetworksRepository;

/**
 * Class NetworkManageService
 * @package core\services\manage
 *
 * @property NetworksRepository $repository
 */
class NetworkManageService
{
    private $repository;

    public function __construct(NetworksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(NetworksForm $form): Networks
    {
        $network = Networks::create($form->name, $form->link, $form->publish);

        $this->repository->save($network);

        return $network;
    }

    public function edit(int $id, NetworksForm $form): void
    {
        $network = $this->repository->get($id);

        $network->edit($form->name, $form->link, $form->publish);

        $this->repository->save($network);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }

    public function activate(int $id): void
    {
        $site = $this->repository->get($id);
        $site->activate();
        $this->repository->save($site);
    }

    public function deactivate(int $id): void
    {
        $site = $this->repository->get($id);
        $site->deactivate();
        $this->repository->save($site);
    }
}