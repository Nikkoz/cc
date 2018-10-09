<?php

namespace core\services\manage;


use core\entities\Exchanges;
use core\forms\manage\ExchangesForm;
use core\repositories\ExchangesRepository;

/**
 * Class ExchangesManageService
 * @package core\services\manage
 *
 * @property ExchangesRepository $repository
 */
class ExchangesManageService
{
    private $repository;

    public function __construct(ExchangesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ExchangesForm $form): Exchanges
    {
        $exchange = Exchanges::create($form->link, $form->name, $form->type, $form->description, $form->publish);

        $this->repository->save($exchange);

        return $exchange;
    }

    public function edit(int $id, ExchangesForm $form): void
    {
        $exchange = $this->repository->get($id);

        $exchange->edit($form->link, $form->name, $form->type, $form->description, $form->publish);

        $this->repository->save($exchange);
    }

    public function remove(int $id): void
    {
        $exchange = $this->repository->get($id);
        $this->repository->remove($exchange);
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