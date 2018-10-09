<?php

namespace core\services\manage\posts;


use core\entities\parse\ForumMessages;
use core\forms\manage\posts\ForumsForm;
use core\repositories\posts\ForumsRepository;

/**
 * Class ForumsManageService
 * @package core\services\manage\posts
 *
 * @property ForumsRepository $repository
 */
class ForumsManageService
{
    private $repository;

    /**
     * ForumsManageService constructor.
     * @param ForumsRepository $repository
     */
    public function __construct(ForumsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ForumsForm $form
     * @return ForumMessages
     */
    public function create(ForumsForm $form): ForumMessages
    {
        $message = ForumMessages::create($form->forum_id, $form->user_name, $form->text, $form->date);

        $this->repository->save($message);

        return $message;
    }

    /**
     * @param int $id
     * @param ForumsForm $form
     */
    public function edit(int $id, ForumsForm $form): void
    {
        $message = $this->repository->get($id);

        $message->edit($form->forum_id, $form->user_name, $form->text, $form->date);

        $this->repository->save($message);
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $message = $this->repository->get($id);
        $this->repository->remove($message);
    }
}