<?php

namespace core\repositories\posts;


use core\entities\parse\Reddit;

class RedditRepository
{
    public function get(int $id): Reddit
    {
        if (!$post = Reddit::findOne($id)) {
            throw new \DomainException('Reddit post is not found.');
        }

        return $post;
    }

    public function save(Reddit $post): void
    {
        if (!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Reddit $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}