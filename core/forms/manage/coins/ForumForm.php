<?php

namespace core\forms\manage\coins;


use core\entities\coins\Forums;
use yii\base\Model;

/**
 * Class ForumForm
 * @package core\forms\manage\coins
 *
 * @property integer $coin_id
 * @property string $link
 * @property string $admin
 *
 * @property array $schedule
 */
class ForumForm extends Model
{
    public $schedule;

    public function __construct(array $forums = [], array $config = [])
    {
        if (!empty($forums)) {
            foreach($forums as $forum) {
                $this->schedule[] = [
                    'id' => $forum->id,
                    'link' => $forum->link,
                    'admin' => $forum->admin,
                ];
            }
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['schedule', 'safe'],
        ];
    }
}