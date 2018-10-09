<?php

namespace core\repositories\posts;


use core\entities\parse\Facebook;

class FacebookRepository
{
    public function get(int $id): Facebook
    {
        if (!$post = Facebook::findOne($id)) {
            throw new \DomainException('Facebook post is not found.');
        }

        return $post;
    }

    public function save(Facebook $post): void
    {
        if (!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Facebook $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}