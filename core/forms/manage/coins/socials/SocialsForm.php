<?php

namespace core\forms\manage\coins\socials;


use core\entities\coins\socials\Networks;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class SocialsForm
 * @package core\forms\manage\coins\socials
 *
 * @property array $social
 */
class SocialsForm extends Model
{
    public $social;

    public function __construct(array $socials = [], array $config = [])
    {
        if (!empty($socials)) {
            foreach ($socials as $social) {
                $this->social[] = [
                    'id' => $social->id,
                    'link' => $social->link,
                    'type' => $social->type,
                    'description' => $social->description,
                ];
            }
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['social', 'safe']
        ];
    }

    public function getType(): array
    {
        return ArrayHelper::map(Networks::find()->all(), 'id', 'name');
    }
}