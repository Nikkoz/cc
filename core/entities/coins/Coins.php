<?php

namespace core\entities\coins;


use core\entities\coins\handbook\Handbook;
use core\entities\coins\socials\Socials;
use core\entities\queries\CoinsQuery;
use core\entities\User;
use core\forms\manage\coins\socials\SocialsForm;
use yii\db\ActiveRecord;
use core\entities\Meta;
use core\entities\Pictures;
use core\entities\behaviors\MetaBehavior;
use yii\behaviors\SluggableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\forms\manage\coins\DataForm;
use core\forms\manage\coins\LinksForm;
use core\entities\behaviors\JsonBehavior;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $alias
 * @property integer $type
 * @property integer $publish
 * @property string $image
 * @property integer $smart_contracts
 * @property string $platform
 * @property string $date_start
 * @property integer $encryption_id
 * @property integer $consensus_id
 * @property integer $mining
 * @property string $max_supply
 * @property string $key_features
 * @property string $use
 * @property array $site
 * @property array $link
 * @property array $forums
 * @property array $chat
 * @property array $source_code
 *
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Meta $meta
 *
 * @property Pictures $picture
 * @property array assignmentsForum
 * @property array assignmentsHandbook
 * @property array assignmentsSocials
 */
class Coins extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $meta;

    public static function tableName(): string
    {
        return '{{%coins}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => MetaBehavior::class,
                'jsonAttribute' => 'meta'
            ], [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'alias'
            ], [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'picture'
                ]
            ], [
                'class' => JsonBehavior::class,
                'attribute' => ['site', 'link', 'chat', 'source_code']
            ]
        ];
    }

    public static function create(string $name, string $code, int $publish, int $type, Meta $meta): self
    {

        $coin = new static();

        $coin->name = $name;
        $coin->code = $code;
        $coin->publish = $publish;
        $coin->type = $type;
        $coin->meta = $meta;

        return $coin;
    }

    public function edit(string $name, string $code, int $publish, int $type, Meta $meta): void
    {
        $this->name = $name;
        $this->code = $code;
        $this->publish = $publish;
        $this->type = $type;
        $this->meta = $meta;
    }

    public function setData(DataForm $form):void
    {
        $this->smart_contracts = $form->smart_contracts;
        $this->platform = $form->platform;
        $this->date_start = $form->date_start;
        $this->encryption_id = $form->encryption_id;
        $this->consensus_id = $form->consensus_id;
        $this->mining = $form->mining;
        $this->max_supply = $form->max_supply;
        $this->key_features = $form->key_features;
        $this->use = $form->use;
    }

    public function setLinks(LinksForm $form):void
    {
        $this->site = $form->site;
        $this->link = $form->link;
        $this->chat = $form->chat;
        $this->source_code = $form->source_code;
    }

    // Picture

    public function assignPicture(int $id): void
    {
        $this->image = $id;
    }

    public function revokePicture(): void
    {
        $this->image = '';
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
            throw new \DomainException(\Yii::t('app', 'Coin is already active.'));
        }

        $this->publish = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isInactive()) {
            throw new \DomainException(\Yii::t('app', 'Coin is already inactive.'));
        }

        $this->publish = self::STATUS_INACTIVE;
    }

    // assignments

    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id'=> 'image']);
    }

    public function getAssignmentsForum(): ActiveQuery
    {
        return $this->hasMany(Forums::class, ['coin_id' => 'id']);
    }

    public function getAssignmentsHandbook(): ActiveQuery
    {
        return $this->hasMany(Handbook::class, ['coin_id' => 'id']);
    }

    public function getAssignmentsSocials(): ActiveQuery
    {
        return $this->hasMany(Socials::class, ['coin_id' => 'id']);
    }

    public function getTypes(): array
    {
        return ['Coin', 'Token'];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public static function find(): CoinsQuery
    {
        return new CoinsQuery(static::class);
    }
}
