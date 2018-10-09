<?php

namespace core\services\manage\posts;


use core\entities\parse\Reddit;
use core\forms\manage\posts\RedditForm;
use core\repositories\posts\RedditRepository;

/**
 * Class RedditManageService
 * @package core\services\manage
 *
 * @property RedditRepository $repository
 */
class RedditManageService
{
    private $repository;

    public function __construct(RedditRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(RedditForm $form): Reddit
    {
        $reddit = Reddit::create($form->title, $form->post_id, $form->coin_id, $form->text, $form->created);
        $reddit->assignUser($form->user);
        $reddit->assignResponses($form->responses);

        $this->repository->save($reddit);

        return $reddit;
    }

    public function edit(int $id, RedditForm $form): void
    {
        $reddit = $this->repository->get($id);

        $reddit->edit($form->title, $form->post_id, $form->coin_id, $form->text, $form->created);
        $reddit->assignUser($form->user);
        $reddit->assignResponses($form->responses);

        $this->repository->save($reddit);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}