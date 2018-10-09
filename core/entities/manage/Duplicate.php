<?php

namespace core\entities\manage;


use core\entities\coins\Coins;
use core\helpers\DuplicateHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Duplicate
 * @package core\entities\manage
 *
 * @property int $coin_id
 * @property int $index_down
 * @property int $index_up
 * @property int $time_down
 * @property int $time_up
 *
 * @property Coins $coin
 */
class Duplicate extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%duplicate}}';
    }

    public static function create(): self
    {
        $duplicate = new static();

        return $duplicate;
    }

    public function edit(): void
    {

    }

    public function getCoin(): ActiveQuery
    {
        return $this->hasOne(Coins::class, ['id' => 'coin_id']);
    }

    public function getDuplicate(): array
    {
        return DuplicateHelper::returnDuplicates($this->coin_id, $this->time_up);
    }
}