<?php

namespace core\entities\coins\handbook;


use core\entities\coins\Coins;
use core\entities\queries\HandbookQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Handbook
 * @package core\entities\coins
 *
 * @property integer $id
 * @property integer $coin_id
 * @property string $title
 * @property string $alias
 * @property integer $check_case
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Handbook extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%handbook}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'alias'
            ]
        ];
    }

    public static function create(string $title, int $publish, int $check_case): self
    {
        $handbook = new static();

        $handbook->title = $title;
        $handbook->publish = $publish;
        $handbook->check_case = $check_case;

        return $handbook;
    }

    public function edit(string $title, int $publish, int $check_case): void
    {
        $this->title = $title;
        $this->publish = $publish;
        $this->check_case = $check_case;
    }

    public function assignCoin($id): void
    {
        $this->coin_id = $id;
    }

    public function getCoin(): ActiveQuery
    {
        return $this->hasOne(Coins::class, ['id' => 'coin_id']);
    }

    public static function find(): HandbookQuery
    {
        return new HandbookQuery(static::class);
    }
}