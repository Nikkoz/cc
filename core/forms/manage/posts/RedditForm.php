<?php

namespace core\forms\manage\posts;


use core\entities\coins\Coins;
use core\entities\parse\Reddit;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class RedditForm
 * @package core\forms\manage\posts
 *
 * @property string $title
 * @property integer $post_id
 * @property integer $coin_id
 * @property string $text
 * @property string $created
 * @property string $link
 *
 * @property array $coins
 *
 * @property UserForm $user
 * @property ResponsesForm $responses
 */
class RedditForm extends CompositeForm
{
    public $title;
    public $post_id;
    public $coin_id;
    public $text;
    public $created;
    public $link;

    public function __construct(Reddit $reddit = null, array $config = [])
    {
        if ($reddit) {
            $this->title = $reddit->title;
            $this->post_id = $reddit->post_id;
            $this->coin_id = $reddit->coin_id;
            $this->text = $reddit->text;
            $this->created = $reddit->created;
            $this->link = $reddit->link;
        }

        $this->user = new UserForm('reddit', $reddit);
        $this->responses = new ResponsesForm($reddit);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['post_id', 'title', 'text', 'created'], 'required'],
            [['coin_id'], 'integer'],
            [['created', 'post_id', 'title'], 'string', 'max' => 255],
            ['text', 'string']
        ];
    }

    public function getCoins(): array
    {
        return ArrayHelper::map(Coins::find()->active()->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['user', 'responses'];
    }
}