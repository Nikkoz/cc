<?php

namespace core\entities\parse;


use core\entities\behaviors\DateBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use core\entities\coins\Forums AS forumCoin;

/**
 * Class Forums
 * @package core\entities\parse
 *
 * @property integer $id
 * @property integer $forum_id
 * @property string $user_name
 * @property string $text
 * @property string $date
 */
class ForumMessages extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%forum_messages}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => DateBehavior::class,
                'attribute' => 'date'
            ]
        ];
    }

    public static function create(int $forum_id, string $user_name, string $text, string $date): self
    {
        $message = new static();

        $message->forum_id = $forum_id;
        $message->user_name = $user_name;
        $message->text = $text;
        $message->date = $date;

        return $message;
    }

    public function edit(int $forum_id, string $user_name, string $text, string $date): void
    {
        $this->forum_id = $forum_id;
        $this->user_name = $user_name;
        $this->text = $text;
        $this->date = $date;
    }

    public function getForums(): array
    {
        return ArrayHelper::map(forumCoin::find()->with('coin')->all(), 'id', 'link');
    }
}