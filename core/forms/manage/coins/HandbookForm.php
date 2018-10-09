<?php

namespace core\forms\manage\coins;


use yii\base\Model;

/**
 * Class HandbookForm
 * @package core\forms\manage\coins
 *
 * @property array $words
 */
class HandbookForm extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $words;
    public $check_case;

    public function __construct(array $handbook = [], array $config = [])
    {
        if (!empty($handbook)) {
            foreach ($handbook as $word) {
                $this->words[] = [
                    'id' => $word->id,
                    'title' => $word->title,
                    'check_case' => $word->check_case,
                    'publish' => $word->publish,
                ];
            }
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['words', 'safe']
        ];
    }
}