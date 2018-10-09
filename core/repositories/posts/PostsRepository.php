<?php

namespace core\repositories\posts;


use core\entities\parse\Posts;

class PostsRepository
{
    public function get(int $id): Posts
    {
        if(!$post = Posts::findOne($id)) {
            throw new \DomainException('Post is not found.');
        }

        return $post;
    }

    public function save(Posts $post): void
    {
        if(!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Posts $post): void
    {
        if(!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}