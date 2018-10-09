<?php

namespace core\repositories\coins;


use core\entities\coins\Forums;

class ForumsRepository
{
    public function get($id): Forums
    {
        if(!$forum = Forums::findOne($id)) {
            throw new \DomainException('Forum is not found.');
        }

        return $forum;
    }

    public function getBy(array $conditions): array
    {
        if(!$forums = Forums::find()->andWhere($conditions)->all()) {
            throw new \DomainException('Forums are not found.');
        }
        return $forums;
    }

    public function save(Forums $forum): void
    {
        if(!$forum->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Forums $forum): void
    {
        if(!$forum->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}