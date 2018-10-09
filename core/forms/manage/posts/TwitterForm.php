<?php

namespace core\forms\manage\posts;


use core\entities\coins\Coins;
use core\entities\parse\Twitter;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class TwitterForm
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
class TwitterForm extends CompositeForm
{
    public $post_id;
    public $coin_id;
    public $text;
    public $created;
    public $page_name;

    public function __construct(Twitter $twit = null, array $config = [])
    {
        if($twit) {
            $this->post_id = $twit->post_id;
            $this->coin_id = $twit->coin_id;
            $this->text = $twit->text;
            $this->created = $twit->created;
            $this->page_name = $twit->page_name;
        }

        $this->user = new UserForm('twitter', $twit);
        $this->responses = new ResponsesForm($twit);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['post_id', 'text', 'created'], 'required'],
            [['post_id', 'coin_id'], 'integer'],
            [['created'], 'string', 'max' => 255],
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