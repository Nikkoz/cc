<?php

namespace core\entities\parse;


use core\entities\behaviors\DateBehavior;
use core\entities\coins\Coins;
use core\entities\coins\handbook\Handbook;
use core\entities\coins\handbook\HandbookAssignments;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * Class PostEntities
 * @package core\entities\parse
 *
 * @property string $title
 * @property string $text
 * @property int $sentiment
 * @property string $page_name
 * @property int $post_id
 * @property int $publish
 *
 * @property string $headline
 * @property Coins $coin
 * @property HandbookAssignments $handbookAssignments
 * @property Handbook[] $handbooks
 */
class PostEntities extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%posts}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ], [
                'class' => DateBehavior::class,
                'attribute' => 'created'
            ]
        ];
    }

    public function getHeadline(): string
    {
        return $this->title ? $this->title : StringHelper::truncateWords($this->text, 10, ' ...');
    }

    public function getCoin(): ?ActiveQuery
    {
        return $this->hasOne(Coins::class, ['id' => 'coin_id']);
    }

    public function getHandbookAssignments(): ActiveQuery
    {
        return $this->hasMany(HandbookAssignments::class, ['post_id' => 'id']);
    }

    public function getHandbooks(): ActiveQuery
    {
        return $this->hasMany(Handbook::class, ['id' => 'handbook_id'])->via('handbookAssignments');
    }

    public function getSense(): string
    {
        $list = [
            '1' => \Yii::t('app', 'Positive'),
            '0' => \Yii::t('app', 'Neutral'),
            '-1' => \Yii::t('app', 'Negative')
        ];

        return $list[$this->sentiment];
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
            throw new \DomainException(\Yii::t('app','Post is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Post is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }
}