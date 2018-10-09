<?php

namespace core\forms\manage\landing\Blocks;


use core\entities\landing\Elements;
use core\forms\manage\CompositeForm;

/**
 * Class ElementTwoForm
 * @package core\forms\manage\landing\Blocks
 *
 * @property integer $block_id
 * @property string $text
 *
 * @property PictureForm $picture
 */
class ElementTwoForm extends CompositeForm
{
    public $block_id;
    public $text;

    public function __construct(Elements $element = null, array $config = [])
    {
        if ($element) {
            $this->block_id = $element->block_id;
            $this->text = $element->text;
        }

        $this->picture = new PictureForm($element);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['text', 'block_id'], 'required'],
            ['text', 'string'],
            ['block_id', 'integer']
        ];
    }

    protected function internalForms(): array
    {
        return ['picture'];
    }
}