<?php

namespace core\repositories\posts;


use core\entities\parse\Twitter;

class TwitterRepository
{
    public function get(int $id): Twitter
    {
        if (!$post = Twitter::findOne($id)) {
            throw new \DomainException('Twitter post is not found.');
        }

        return $post;
    }

    public function save(Twitter $post): void
    {
        if (!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Twitter $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}