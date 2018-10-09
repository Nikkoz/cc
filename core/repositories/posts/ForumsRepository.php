<?php

namespace core\repositories\posts;


use core\entities\parse\ForumMessages;

class ForumsRepository
{
    public function get(int $id): ForumMessages
    {
        if(!$forum = ForumMessages::findOne($id)) {
            throw new \DomainException('Forum message is not found.');
        }

        return $forum;
    }

    public function save(ForumMessages $forum): void
    {
        if(!$forum->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param ForumMessages $forum
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(ForumMessages $forum): void
    {
        if(!$forum->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}