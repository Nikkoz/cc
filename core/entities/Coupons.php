<?php

namespace core\entities;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Coupons
 * @package core\entities
 *
 * @property string $code
 * @property int $type
 * @property int $discount
 * @property int $publish
 */
class Coupons extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%coupons}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public static function create(string $code, int $type, int $discount, int $publish): self
    {
        $coupon = new static();

        $coupon->code = $code;
        $coupon->type = $type;
        $coupon->discount = $discount;
        $coupon->publish = $publish;

        return $coupon;
    }

    public function edit(string $code, int $type, int $discount, int $publish): void
    {
        $this->code = $code;
        $this->type = $type;
        $this->discount = $discount;
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
            throw new \DomainException(\Yii::t('app', 'Coupon is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Coupon is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getTypes(): array
    {
        return [\Yii::t('app', 'Register'), \Yii::t('app', 'Discount')];
    }
}