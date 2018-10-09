<?php

namespace core\services\manage;


use core\entities\Seo;
use core\forms\manage\SeoForm;
use core\repositories\SeoRepository;

/**
 * Class SeoManageService
 * @package core\services\manage
 *
 * @property SeoRepository $repository
 */
class SeoManageService
{
    private $repository;

    public function __construct(SeoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(SeoForm $form): Seo
    {
        $seo = Seo::create($form->name, $form->alias, $form->seo_title, $form->seo_keywords, $form->seo_description);

        $this->repository->save($seo);

        return $seo;
    }

    public function edit(int $id, SeoForm $form): void
    {
        $seo = $this->repository->get($id);
        $seo->edit($form->name, $form->alias, $form->seo_title, $form->seo_keywords, $form->seo_description);

        $this->repository->save($seo);
    }

    public function remove(int $id): void
    {
        $seo = $this->repository->get($id);
        $this->repository->remove($seo);
    }
}