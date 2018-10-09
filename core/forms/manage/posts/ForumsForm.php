<?php

namespace core\forms\manage\posts;


use core\entities\parse\ForumMessages;
use core\entities\coins\Forums AS forumCoin;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ForumsForm
 * @package core\forms\manage\posts
 *
 * @property integer $forum_id
 * @property string $user_name
 * @property string $text
 * @property string $date
 *
 * @property ForumMessages[] $forums
 */
class ForumsForm extends Model
{
    public $forum_id;
    public $user_name;
    public $text;
    public $date;

    public function __construct(ForumMessages $forum = null, array $config = [])
    {
        if($forum) {
            $this->forum_id = $forum->forum_id;
            $this->user_name = $forum->user_name;
            $this->text = $forum->text;
            $this->date = $forum->date;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['forum_id', 'user_name', 'text'], 'required'],
            ['forum_id', 'integer'],
            [['user_name', 'date'], 'string', 'max' => 255],
            ['text', 'string']
        ];
    }

    public function getForums(): array
    {
        return ArrayHelper::map(forumCoin::find()->with('coin')->all(), 'id', 'link');
    }
}