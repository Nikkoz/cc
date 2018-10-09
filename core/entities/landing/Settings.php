<?php

namespace core\entities\landing;


use core\entities\behaviors\JsonBehavior;
use yii\db\ActiveRecord;

/**
 * Class Settings
 * @package core\entities\landing
 *
 * @property string $settings
 */
class Settings extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%landing_settings}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => JsonBehavior::class,
                'attribute' => 'settings'
            ]
        ];
    }

    public function edit(array $email, array $donate): void
    {
        $this->settings = [
            'email' => $email,
            'donate' => $donate
        ];
    }
}