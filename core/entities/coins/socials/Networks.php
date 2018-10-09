<?php

namespace core\entities\coins\socials;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class SocialNetworks
 * @package core\entities\coins\socials
 *
 * @property string $name
 * @property string $link
 * @property integer $publish
 */
class Networks extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%social_network}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'alias'
            ]
        ];
    }

    public static function create(string $name, string $link, int $publish): self
    {
        $network = new static();

        $network->name = $name;
        $network->link = $link;
        $network->publish = $publish;

        return $network;
    }

    public function edit(string $name, string $link, int $publish): void
    {
        $this->name = $name;
        $this->link = $link;
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
            throw new \DomainException(\Yii::t('app', 'Network is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Network is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }
}