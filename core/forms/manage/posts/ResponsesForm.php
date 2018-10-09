<?php

namespace core\forms\manage\posts;


use core\entities\parse\Facebook;
use core\entities\parse\Reddit;
use core\entities\parse\Twitter;
use yii\base\Model;

/**
 * Class ResponsesForm
 * @package core\forms\manage\posts
 *
 * @property integer $shares_count
 * @property integer $likes_count
 * @property integer $comments_count
 */
class ResponsesForm extends Model
{
    public $shares_count;
    public $likes_count;
    public $comments_count;

    /**
     * ResponsesForm constructor.
     * @param Twitter|Facebook|Reddit $post
     * @param array $config
     */
    public function __construct($post = null, array $config = [])
    {
        if($post) {
            $this->shares_count = $post->shares_count;
            $this->likes_count = $post->likes_count;
            $this->comments_count = $post->comments_count;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['shares_count', 'likes_count', 'comments_count'], 'integer']
        ];
    }
}