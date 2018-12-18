<?php

namespace core\helpers\copy;


use core\entities\parse\Posts;

final class PostsHelper
{
    public static function getPosts(int $limit = 100, int $page = 0)
    {
        $result = RestHelper::send(['type' => 'posts','limit' => $limit, 'page' => $page]);
        $result = json_decode(json_encode($result), true);
        return \call_user_func_array('array_merge', $result);
    }

    public static function savePost()
    {

    }
}