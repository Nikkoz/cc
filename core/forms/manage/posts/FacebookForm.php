<?php

namespace core\forms\manage\posts;


use core\entities\coins\Coins;
use core\entities\parse\Facebook;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class FacebookForm
 * @package core\forms\manage\posts
 *
 * @property integer $post_id
 * @property integer $coin_id
 * @property string $text
 * @property string $created
 * @property string $page_name
 *
 * @property array $coins
 *
 * @property UserForm $user
 * @property ResponsesForm $responses
 */
class FacebookForm extends CompositeForm
{
    public $post_id;
    public $coin_id;
    public $text;
    public $created;
    public $page_name;

    public function __construct(Facebook $facebook = null, array $config = [])
    {
        if ($facebook) {
            $this->post_id = $facebook->post_id;
            $this->coin_id = $facebook->coin_id;
            $this->text = $facebook->text;
            $this->created = $facebook->created;
            $this->page_name = $facebook->page_name;
        }

        $this->user = new UserForm('facebook', $facebook);
        $this->responses = new ResponsesForm($facebook);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['post_id', 'text', 'created'], 'required'],
            [['coin_id'], 'integer'],
            [['created', 'post_id'], 'string', 'max' => 255],
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