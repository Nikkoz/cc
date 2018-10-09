<?php

namespace core\services\manage\posts;


use core\entities\parse\Posts;
use core\forms\manage\posts\PostsForm;
use core\repositories\coins\HandbookRepository;
use core\repositories\posts\PostsRepository;

/**
 * Class PostsManageService
 * @package core\services\manage
 *
 * @property PostsRepository $repository
 * @property HandbookRepository $handbookRepository
 */
class PostsManageService
{
    private $repository;
    private $handbookRepository;

    /**
     * PostsManageService constructor.
     * @param PostsRepository $repository
     * @param HandbookRepository $handbookRepository
     */
    public function __construct(PostsRepository $repository, HandbookRepository $handbookRepository)
    {
        $this->repository = $repository;
        $this->handbookRepository = $handbookRepository;
    }

    /**
     * @param PostsForm $form
     * @return Posts
     */
    public function create(PostsForm $form): Posts
    {
        $post = Posts::create($form->title, $form->link, $form->section, $form->created, $form->publish, $form->text);

        foreach ($form->handbook->handbook as $hb) {
            $handbook = $this->handbookRepository->get($hb);
            $post->assignHandbook($handbook->id);
        }

        if($form->site) {
            $post->assignSite($form->site);
        }

        $this->repository->save($post);

        return $post;
    }

    /**
     * @param int $id
     * @param PostsForm $form
     */
    public function edit(int $id, PostsForm $form): void
    {

        $post = $this->repository->get($id);

        $post->edit($form->title, $form->link, $form->section, $form->created, $form->publish, $form->text);

        if($form->site) {
            $post->assignSite($form->site);
        }

        $post->revokeHandbooks();

        $this->repository->save($post);

        foreach ($form->handbook->handbook as $hb) {
            $handbook = $this->handbookRepository->get($hb);
            $post->assignHandbook($handbook->id);
        }

        $this->repository->save($post);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }

    public function activate(int $id): void
    {
        $post = $this->repository->get($id);
        $post->activate();
        $this->repository->save($post);
    }

    public function deactivate(int $id): void
    {
        $post = $this->repository->get($id);
        $post->deactivate();
        $this->repository->save($post);
    }
}