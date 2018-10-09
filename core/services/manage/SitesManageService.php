<?php

namespace core\services\manage;

use core\entities\Sites;
use core\forms\manage\SitesForm;
use core\repositories\SitesRepository;

/**
 * Class SitesManageService
 * @package core\services\manage
 *
 * @property SitesRepository $repository
 */
class SitesManageService
{
    private $repository;

    public function __construct(SitesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(SitesForm $form): Sites
    {
        $site = Sites::create($form->name, $form->link, $form->publish);

        $this->repository->save($site);

        return $site;
    }

    public function edit(int $id, SitesForm $form): void
    {
        $site = $this->repository->get($id);

        $site->edit($form->name, $form->link, $form->publish);

        $this->repository->save($site);
    }

    public function remove($id): void
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