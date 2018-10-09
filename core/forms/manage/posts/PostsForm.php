<?php

namespace core\forms\manage\posts;


use core\entities\parse\Posts;
use core\entities\Sites;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class PostsForm
 * @package core\forms\manage\posts
 *
 * @property string $title
 * @property string $link
 * @property string $section
 * @property integer $created
 * @property integer $publish
 * @property string $text
 * @property integer $site
 * @property HandbookForm $handbook
 */
class PostsForm extends CompositeForm
{
    public $title;
    public $link;
    public $section;
    public $created;
    public $publish;
    public $text;
    public $site;

    public function __construct(Posts $post = null, array $config = [])
    {
        if ($post) {
            $this->title = $post->title;
            $this->link = $post->link;
            $this->section = $post->section;
            $this->created = $post->created;
            $this->publish = $post->publish;
            $this->text = $post->text;
            $this->site = $post->site_id;
        } else {
            $this->created = \Date('d.m.Y H:i');
        }

        $this->handbook = new HandbookForm($post);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'link', 'created', 'text', 'site'], 'required'],
            [['title', 'link', 'section', 'created'], 'string', 'max' => 255],
            ['text', 'string'],
            [['publish', 'site'], 'integer'],
        ];
    }

    public function sitesList(): array
    {
        return ArrayHelper::map(Sites::find()->active()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['handbook'];
    }
}