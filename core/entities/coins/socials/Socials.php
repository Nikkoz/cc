<?php

namespace core\entities\coins\socials;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Socials
 * @package core\entities\coins
 *
 * @property string $link
 * @property integer $type
 * @property string $description
 * @property integer $coin_id
 */
class Socials extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%social_links}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public static function create(string $link, int $type, string $description): self
    {
        $social = new static();

        $social->link = $link;
        $social->type = $type;
        $social->description = $description;

        return $social;
    }

    public function edit(string $link, int $type, string $description): void
    {
        $this->link = $link;
        $this->type = $type;
        $this->description = $description;
    }

    public function assignCoin(int $coinId): void
    {
        $this->coin_id = $coinId;
    }
}