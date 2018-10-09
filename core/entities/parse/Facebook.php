<?php

namespace core\entities\parse;


use core\entities\coins\Coins;
use core\forms\manage\posts\ResponsesForm;
use core\forms\manage\posts\UserForm;
use yii\helpers\ArrayHelper;

/**
 * Class Facebook
 * @package core\entities\parse
 *
 * @property integer $id
 * @property string $post_id
 * @property integer $coin_id
 * @property string $page_name
 * @property string $text
 * @property integer $user_id
 * @property integer $created
 * @property string $user_name
 * @property integer $shares_count
 * @property integer $likes_count
 * @property integer $comments_count
 *
 * @property string $type
 * @property Coins[] $coins
 */
class Facebook extends PostEntities
{
    public static function create(string $post_id, int $coin_id, string $text, string $created): self
    {
        $post = new static();

        $post->post_id = $post_id;
        $post->coin_id = $coin_id;
        $post->text = $text;
        $post->created = $created;

        $post->type = 'facebook';

        return $post;
    }

    public function edit(string $post_id, int $coin_id, string $text, string $created): void
    {
        $this->post_id = $post_id;
        $this->coin_id = $coin_id;
        $this->text = $text;
        $this->created = $created;

        $this->type = 'facebook';
    }

    public function assignUser(UserForm $form): void
    {
        $this->user_id = $form->user_id;
        $this->user_name = $form->user_name;
    }

    public function assignResponses(ResponsesForm $form): void
    {
        $this->shares_count = $form->shares_count;
        $this->likes_count = $form->likes_count;
        $this->comments_count = $form->comments_count;
    }
}