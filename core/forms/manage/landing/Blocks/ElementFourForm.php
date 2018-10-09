<?php

namespace core\forms\manage\landing\Blocks;


use core\entities\landing\Elements;
use core\forms\manage\CompositeForm;

/**
 * Class ElementFourForm
 * @package core\forms\manage\landing\Blocks
 *
 * @property integer $block_id
 * @property string $text
 * @property string $preview
 *
 * @property PictureForm $picture
 */
class ElementFourForm extends CompositeForm
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

        $this->picture = new PictureForm($element);

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

    protected function internalForms(): array
    {
        return ['picture'];
    }
}