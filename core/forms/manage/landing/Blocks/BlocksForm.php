<?php

namespace core\forms\manage\landing\blocks;


use core\entities\landing\Blocks;
use yii\base\Model;

/**
 * Class BlocksForm
 * @package core\forms\manage\landing
 *
 * @property string $phrase_one
 * @property string $phrase_two
 * @property string $phrase_three
 */
class BlocksForm extends Model
{
    public $phrase_one;
    public $phrase_two;
    public $phrase_three;

    public function __construct(Blocks $block = null, array $config = [])
    {
        if($block) {
            $this->phrase_one = $block->phrase_one;
            $this->phrase_two = $block->phrase_two;
            $this->phrase_three = $block->phrase_three;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['phrase_one', 'phrase_two', 'phrase_three'], 'string']
        ];
    }
}