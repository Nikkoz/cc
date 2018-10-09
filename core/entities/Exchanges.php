<?php

namespace core\entities;


use core\entities\coins\socials\Networks;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Exchanges
 * @package core\entities
 *
 * @property integer $id
 * @property string $link
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property boolean $publish
 *
 * @property Networks $network
 * @property User $user
 */
class Exchanges extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%exchanges}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public static function create(string $link, string $name, int $type, string $description, int $publish): self
    {
        $exchange = new static();

        $exchange->link = $link;
        $exchange->name = $name;
        $exchange->type = $type;
        $exchange->description = $description;
        $exchange->publish = $publish;

        return $exchange;
    }

    public function edit(string $link, string $name, int $type, string $description, int $publish): void
    {
        $this->link = $link;
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->publish = $publish;
    }

    public function isActive(): bool
    {
        return $this->publish == self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->publish == self::STATUS_INACTIVE;
    }

    public function activate(): void
    {
        if($this->isActive()) {
            throw new \DomainException(\Yii::t('app', 'Exchange is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Exchange is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }

    public function getNetwork(): ActiveQuery
    {
        return $this->hasOne(Networks::class, ['id' => 'type']);
    }

    public function getNetworks(): array
    {
        return Networks::find()->asArray()->all();
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}