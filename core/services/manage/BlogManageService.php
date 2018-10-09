<?php

namespace core\services\manage;


use core\entities\Blog;
use core\entities\Pictures;
use core\forms\manage\blog\BlogForm;
use core\repositories\BlogRepository;
use core\repositories\PicturesRepository;
use core\services\TransactionManager;

/**
 * Class BlogManageService
 * @package core\services\manage
 *
 * @property BlogRepository $repository
 * @property PicturesRepository $pictureRepository
 * @property TransactionManager $transaction
 */
class BlogManageService
{
    private $repository;
    private $pictureRepository;
    private $transaction;

    public function __construct(
        BlogRepository $repository,
        PicturesRepository $pictureRepository,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->pictureRepository = $pictureRepository;
        $this->transaction = $transaction;
    }

    public function create(BlogForm $form): Blog
    {
        $post = Blog::create(
            $form->coin_id,
            $form->title,
            $form->date,
            $form->index ?: null,
            $form->direction,
            $form->views ?: null,
            $form->likes ?: null,
            $form->text,
            $form->publish
        );

        $this->transaction->wrap(function () use ($post, $form) {
            if($form->picture->file) {
                $file = $this->pictureRepository->saveFile($form->picture->file, 'blog');

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $post->assignPicture($picture->id);
            }

            $this->repository->save($post);
        });

        return $post;
    }

    public function edit(int $id, BlogForm $form): void
    {
        $post = $this->repository->get($id);
        $post->edit(
            $form->coin_id,
            $form->title,
            $form->date,
            $form->index ?: null,
            $form->direction,
            $form->views ?: null,
            $form->likes ?: null,
            $form->text,
            $form->publish
        );

        $this->transaction->wrap(function () use ($post, $form) {
            if($form->picture->file) {
                $file = $this->pictureRepository->saveFile($form->picture->file, 'blog');

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $post->image);

                $post->assignPicture($picture->id);
            }

            $this->repository->save($post);
        });
    }

    public function remove(int $id): void
    {
        $post = $this->repository->get($id);

        if($post->image) {
            $picture = $this->pictureRepository->get($post->image);
            $this->pictureRepository->remove($picture, 'blog');
        }

        $this->repository->remove($post);
    }

    public function removePicture(int $id): void
    {
        $post = $this->repository->get($id);
        $picture = $this->pictureRepository->get($post->image);

        $post->revokePicture();
        $this->pictureRepository->remove($picture, 'blog');
    }

    private function checkPicture(int $newId, int $id = null): void
    {
        if ($id && $id != $newId) {
            $picture = $this->pictureRepository->get($id);
            $this->pictureRepository->remove($picture, 'blog');
        }
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