<?php

namespace core\forms\manage\landing;


use core\entities\landing\Settings;
use yii\base\Model;

/**
 * Class SettingsForm
 * @package core\forms\manage\landing
 *
 * @property string $email
 * @property string $donate
 */
class SettingsForm extends Model
{
    public $email;
    public $donate;

    public function __construct(Settings $settings = null, array $config = [])
    {
        if($settings) {
            $this->email = $settings->settings['email'] ?: [];
            $this->donate = $settings->settings['donate'] ?: [];
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['email', 'donate'], 'safe']
        ];
    }
}