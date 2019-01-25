<?php

namespace backend\widgets;

//use app\base\Js;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Class Select2
 * @package admin\widgets
 */
class Select2 extends InputWidget
{
    /**
     * @var
     */
    public $items;
    /**
     * @var bool
     */
    public $multiple = false;
    /**
     * @var
     */
    public $size;
    /**
     * @var int
     */
    public $maximumSelectionLength = 9999;

    /**
     *
     */
    public function init()
    {
        parent::init();

        \backend\assets\Select2Asset::register($this->getView());
    }

    /**
     *
     */
    public function run()
    {
        echo Html::activeListBox($this->model, $this->attribute, $this->items, ['multiple' => $this->multiple, 'unselect' => null]);
        $id = Html::getInputId($this->model, $this->attribute);

        $options = ArrayHelper::merge($this->options, [
            'multiple' => $this->multiple,
            'width' => '100%',
            'maximumSelectionLength' => $this->maximumSelectionLength,
        ]);

        $templateSelection = <<<HTML
function(b){
	return b.text.replace(/^>*/g, '');
}
HTML;
        $options['templateSelection'] = new JsExpression($templateSelection);
        if (!isset($options['language'])) {
            $options['language'] = substr(\Yii::$app->language, 0, 2);
        }

        $options = \yii\helpers\Json::encode($options);
        $this->getView()->registerJs("jQuery('#{$id}').select2({$options})");
    }
}