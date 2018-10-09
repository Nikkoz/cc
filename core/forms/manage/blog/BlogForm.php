<?php

namespace core\forms\manage\blog;

use core\entities\Blog;
use core\entities\coins\Coins;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class BlogForm
 * @package core\forms\manage
 *
 * @property integer $id
 * @property integer $image
 * @property integer $coin_id
 * @property string $title
 * @property string $alias
 * @property integer $date
 * @property integer $index
 * @property string $direction
 * @property integer $views
 * @property integer $likes
 * @property string $text
 * @property integer $publish
 *
 * @property PictureForm $picture
 * @property Coins[] $coins
 * @property array $rout
 */
class BlogForm extends CompositeForm
{
    public $coin_id;
    public $title;
    public $date;
    public $index;
    public $direction;
    public $views;
    public $likes;
    public $text;
    public $publish;

    public function __construct(Blog $post = null, array $config = [])
    {
        if($post) {
            $this->coin_id = $post->coin_id;
            $this->title = $post->title;
            $this->date = $post->date;
            $this->index = $post->index;
            $this->direction = $post->direction;
            $this->views = $post->views;
            $this->likes = $post->likes;
            $this->text = $post->text;
            $this->publish = $post->publish;
        }

        $this->picture = new PictureForm($post);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'text', 'date'], 'required'],
            [['title', 'date', 'direction'], 'string', 'max' => 255],
            ['text', 'string'],
            ['publish', 'boolean'],
            [['coin_id', 'index', 'views', 'likes'], 'integer']
        ];
    }

    public function getCoins(): array
    {
        return ArrayHelper::map(Coins::find()->active()->all(), 'id', 'name');
    }

    public function getRout(): array
    {
        return [
            'up' => \Yii::t('app', 'Growth up'),
            'down' => \Yii::t('app', 'Growth down'),
        ];
    }

    protected function internalForms(): array
    {
        return ['picture'];
    }
}