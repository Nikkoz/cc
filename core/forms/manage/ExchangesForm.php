<?php

namespace core\forms\manage;


use core\entities\coins\socials\Networks;
use core\entities\Exchanges;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ExchangesForm
 * @package core\forms\manage
 *
 * @property string $link
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property boolean $publish
 *
 * @property Networks[] $types
 */
class ExchangesForm extends Model
{
    public $link;
    public $name;
    public $type;
    public $description;
    public $publish;

    public function __construct(Exchanges $exchange = null, array $config = [])
    {
        if ($exchange) {
            $this->link = $exchange->link;
            $this->name = $exchange->name;
            $this->type = $exchange->type;
            $this->description = $exchange->description;
            $this->publish = $exchange->publish;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['link', 'name', 'type'], 'required'],
            [['link', 'name'], 'string', 'max' => 255],
            ['description', 'string'],
            ['type', 'integer'],
            ['publish', 'boolean']
        ];
    }

    public function getTypes(): array
    {
        return ArrayHelper::map(Networks::find()->all(), 'id', 'name');
    }
}