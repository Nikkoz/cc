<?php

namespace core\services\manage\posts;


use core\entities\parse\Facebook;
use core\forms\manage\posts\FacebookForm;
use core\repositories\posts\FacebookRepository;

/**
 * Class FacebookManageService
 * @package core\services\manage
 *
 * @property FacebookRepository $repository
 */
class FacebookManageService
{
    private $repository;

    /**
     * FacebookManageService constructor.
     * @param FacebookRepository $repository
     */
    public function __construct(FacebookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FacebookForm $form
     * @return Facebook
     */
    public function create(FacebookForm $form): Facebook
    {
        $facebook = Facebook::create($form->post_id, $form->coin_id, $form->text, $form->created);
        $facebook->assignUser($form->user);
        $facebook->assignResponses($form->responses);

        $this->repository->save($facebook);

        return $facebook;
    }

    /**
     * @param int $id
     * @param FacebookForm $form
     */
    public function edit(int $id, FacebookForm $form): void
    {
        $facebook = $this->repository->get($id);

        $facebook->edit($form->post_id, $form->coin_id, $form->text, $form->created);
        $facebook->assignUser($form->user);
        $facebook->assignResponses($form->responses);

        $this->repository->save($facebook);
    }

    /**
     * @param int $id
     */
    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}