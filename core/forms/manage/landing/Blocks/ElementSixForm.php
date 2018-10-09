<?php

namespace core\forms\manage\landing\Blocks;


use core\entities\landing\Elements;
use yii\base\Model;

/**
 * Class ElementSixForm
 * @package core\forms\manage\landing\Blocks
 *
 * @property integer $block_id
 * @property string $text
 * @property string $preview
 */
class ElementSixForm extends Model
{
    public $block_id;
    public $text;
    public $preview;

    public function __construct(Elements $element = null, array $config = [])
    {
        if ($element) {
            $this->block_id = $element->block_id;
            $this->text = $element->text;
            $this->preview = $element->preview;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['text', 'block_id'], 'required'],
            [['text', 'preview'], 'string'],
            ['block_id', 'integer']
        ];
    }
}