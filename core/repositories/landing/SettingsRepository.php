<?php

namespace core\repositories\landing;


use core\entities\landing\Settings;

class SettingsRepository
{
    public function get(int $id): Settings
    {
        if (!$settings = Settings::findOne($id)) {
            throw new \DomainException('Settings is not found.');
        }

        return $settings;
    }

    public function save(Settings $settings): void
    {
        if(!$settings->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Settings $settings): void
    {
        if(!$settings->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}