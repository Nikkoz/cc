<?php

namespace core\entities;


use core\entities\behaviors\DateBehavior;
use core\entities\coins\Coins;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Blog
 * @package core\entities
 *
 * @property integer $id
 * @property integer $image
 * @property integer $coin_id
 * @property string $title
 * @property string $alias
 * @property integer $date
 * @property integer $index
 * @property string $direction
 * @property integer $views
 * @property integer $likes
 * @property string $text
 * @property integer $publish
 *
 * @property Coins[] $coins
 * @property Coins $coin
 * @property Pictures $picture
 */
class Blog extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return '{{%blog}}';
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
            ], [
                'class' => DateBehavior::class,
                'attribute' => 'date'
            ]
        ];
    }

    public static function create(?int $coin_id, string $title, string $date, ?int $index, ?string $direction, ?int $views, ?int $likes, string $text, int $publish): self
    {
        $post = new static();

        $post->coin_id = $coin_id;
        $post->title = $title;
        $post->date = $date;
        $post->index = $index;
        $post->direction = $direction;
        $post->views = $views;
        $post->likes = $likes;
        $post->text = $text;
        $post->publish = $publish;

        return $post;
    }

    public function edit(?int $coin_id, string $title, string $date, ?int $index, ?string $direction, ?int $views, ?int $likes, string $text, int $publish): void
    {
        $this->coin_id = $coin_id;
        $this->title = $title;
        $this->date = $date;
        $this->index = $index;
        $this->direction = $direction;
        $this->views = $views;
        $this->likes = $likes;
        $this->text = $text;
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
            throw new \DomainException(\Yii::t('app', 'Blog is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Blog is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }

    public function assignPicture(int $id): void
    {
        $this->image = $id;
    }

    public function revokePicture(): void
    {
        $this->image = '';
    }

    public function getCoins(): array
    {
        return ArrayHelper::map(Coins::find()->active()->all(), 'id', 'name');
    }

    public function getCoin(): ActiveQuery
    {
        return $this->hasOne(Coins::class, ['id' => 'coin_id']);
    }

    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id'=> 'image']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    // для фильтра в GridView
    public static function getCoinsFilter():array
    {
        return ArrayHelper::map(Coins::find()->active()->all(), 'id', 'name');
    }
}