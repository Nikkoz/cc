<?php

namespace core\entities;


use core\entities\queries\SitesQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Sites
 * @package core\entities
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $link
 * @property integer $publish
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $create_by
 * @property integer $update_by
 */
class Sites extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%settings_sites}}';
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
        $site = new static();

        $site->name = $name;
        $site->link = $link;
        $site->publish = $publish;

        return $site;
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
            throw new \DomainException(\Yii::t('app', 'Site is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Site is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }

    public static function find(): SitesQuery
    {
        return new SitesQuery(static::class);
    }
}