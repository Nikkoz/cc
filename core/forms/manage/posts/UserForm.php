<?php

namespace core\forms\manage\posts;


use core\entities\parse\Facebook;
use core\entities\parse\Reddit;
use core\entities\parse\Twitter;
use yii\base\Model;

/**
 * Class UserForm
 * @package core\forms\manage\posts
 *
 * @property integer $user_id
 * @property string $user_name
 *
 * @property string $type
 */
class UserForm extends Model
{
    public $user_id;
    public $user_name;

    public $type;

    /**
     * UserForm constructor.
     * @param string $type
     * @param Twitter|Facebook|Reddit $post
     * @param array $config
     */
    public function __construct(string $type, $post = null, array $config = [])
    {
        if($post) {
            $this->user_id = $post->user_id;
            $this->user_name = $post->user_name;
        }

        $this->type = $type;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['user_id', 'user_name'], 'required', 'when' => function($model) {
                return $model->type != 'reddit';
            }, 'enableClientValidation' => false],
            ['user_id', 'integer'],
            ['user_name', 'string', 'max' => 255]
        ];
    }
}