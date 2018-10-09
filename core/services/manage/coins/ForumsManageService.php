<?php

namespace core\services\manage\coins;


use core\entities\coins\Forums;
use core\forms\manage\coins\ForumForm;
use core\repositories\coins\ForumsRepository;

/**
 * Class ForumsManageService
 * @package core\services\manage
 *
 * @property ForumsRepository $repository
 */
class ForumsManageService
{
    private $repository;

    public function __construct(ForumsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ForumForm $form): Forums
    {
        $forum = Forums::create($form->link, $form->admin);

        $forum->assignCoin($form->coin_id);

        $forum->save();

        return $forum;
    }
}