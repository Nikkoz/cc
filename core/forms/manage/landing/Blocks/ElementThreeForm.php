<?php

namespace core\forms\manage\landing\Blocks;


use core\entities\coins\Coins;
use core\entities\landing\Elements;
use core\forms\manage\CompositeForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class ElementThreeForm
 * @package core\forms\manage\landing\Blocks
 *
 * @property integer $block_id
 * @property string $text
 *
 * @property integer $coin
 * @property string $date
 * @property string $site
 * @property string $link
 * @property integer $growthCapitalization
 * @property integer $type
 * @property array $blocks
 *
 * @property PictureForm $picture
 * @property Coins $coins
 * @property array $types
 */
class ElementThreeForm extends CompositeForm
{
    public $block_id;
    public $coin;
    public $date;
    public $site;
    public $link;
    public $growthCapitalization;//gupkap
    public $type;//gupkapplus
    public $blocks;

    public $text;

    public function __construct(Elements $element = null, array $config = [])
    {
        if ($element) {
            $this->block_id = $element->block_id;
            $this->coin = $element->data['coin'];
            $this->date = $element->data['date'];
            $this->site = $element->data['site'];
            $this->link = $element->data['link'];
            $this->growthCapitalization = $element->data['growthCapitalization'];
            $this->type = $element->data['type'];
            $this->blocks = $element->data['blocks'];
        }

        $this->picture = new PictureForm($element);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['block_id'], 'required'],
            [['coin', 'block_id', 'growthCapitalization', 'type'], 'integer'],
            [['date', 'site', 'link'], 'string', 'max' => 255],
            ['blocks', 'safe']
        ];
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->text = Json::encode([
                'coin' => $this->coin,
                'date' => $this->date,
                'site' => $this->site,
                'link' => $this->link,
                'growthCapitalization' => $this->growthCapitalization,
                'type' => $this->type,
                'blocks' => $this->blocks
            ]);

            return true;
        }

        return false;
    }

    public function getCoins(): array
    {
        return ArrayHelper::map(Coins::find()->active()->all(), 'id', 'name');
    }

    public function getTypes()
    {
        return [
            1 => \Yii::t('app', 'Growth up'),
            2 => \Yii::t('app', 'Not changes'),
            3 => \Yii::t('app', 'Growth down'),
        ];
    }

    protected function internalForms(): array
    {
        return ['picture'];
    }
}