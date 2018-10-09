<?php

namespace core\repositories;


use core\entities\Blog;

class BlogRepository
{
    public function get(int $id): Blog
    {
        if (!$post = Blog::findOne($id)) {
            throw new \DomainException('Post is not found.');
        }

        return $post;
    }

    public function save(Blog $post): void
    {
        if (!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Blog $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}