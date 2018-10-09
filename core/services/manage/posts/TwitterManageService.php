<?php

namespace core\services\manage\posts;


use core\entities\parse\Twitter;
use core\forms\manage\posts\TwitterForm;
use core\repositories\posts\TwitterRepository;

/**
 * Class TwitterManageService
 * @package core\services\manage
 *
 * @property TwitterRepository $repository
 */
class TwitterManageService
{
    private $repository;

    public function __construct(TwitterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TwitterForm $form): Twitter
    {
        $twitter = Twitter::create($form->post_id, $form->coin_id, $form->text, $form->created);
        $twitter->assignUser($form->user);
        $twitter->assignResponses($form->responses);

        $this->repository->save($twitter);

        return $twitter;
    }

    public function edit(int $id, TwitterForm $form): void
    {
        $post = $this->repository->get($id);

        $post->edit($form->post_id, $form->coin_id, $form->text, $form->created);
        $post->assignUser($form->user);
        $post->assignResponses($form->responses);

        $this->repository->save($post);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}