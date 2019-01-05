<?php

namespace core\helpers;


use core\entities\coins\Coins;

class CoinHelper
{
    public static function serializeForApi(Coins $coin)
    {
        $picture = $coin->picture;

        return [
            'id' => $coin->id,
            'name' => $coin->name,
            'code' => $coin->code,
            'alias' => $coin->alias,
            'image' => [
                'id' => $picture->id,
                'name' => $picture->name,
                'description' => $picture->description,
                'sort' => $picture->sort,
                'file' => $picture->getFile('coins'),
            ],
            'site' => $coin->site,
            'link' => $coin->link,
            'chat' => $coin->chat,
            'source_code' => $coin->source_code,
            'type' => $coin->getTypes()[$coin->type],
            'smart_contracts' => $coin->smart_contracts,
            'platform' => $coin->platform,
            'date_start' => $coin->date_start,
            'encryption' => $coin->encryption,
            'consensus' => $coin->consensus,
            'mining' => $coin->mining,
            'max_supply' => $coin->max_supply,
            'key_features' => $coin->key_features,
            'use' => $coin->use,
            'publish' => $coin->publish,
            'meta' => $coin->meta,
        ];
    }
}