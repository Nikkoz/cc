<?php

namespace core\entities\landing;


use core\entities\coins\Coins;
use core\entities\Pictures;
use core\entities\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Elements
 * @package core\entities\landing
 *
 * @property integer $id
 * @property integer $block_id
 * @property string $text
 * @property string $preview
 * @property integer $image
 *
 * @property array $data
 *
 * @property Pictures $picture
 */
class Elements extends ActiveRecord
{
    public $data;

    public static function tableName(): string
    {
        return '{{%landing_blocks_elements}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public static function create(int $block_id, string $text, string $preview = ''): self
    {
        $element = new static();

        $element->block_id = $block_id;
        $element->text = $text;
        $element->preview = $preview;

        return $element;
    }

    public function edit(int $block_id, string $text, string $preview = ''): void
    {
        $this->block_id = $block_id;
        $this->text = $text;
        $this->preview = $preview;
    }

    public function assignPicture(int $id): void
    {
        $this->image = $id;
    }

    public function revokePicture(): void
    {
        $this->image = '';
    }

    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id'=> 'image']);
    }

    public function getCoin(): Coins
    {
        return Coins::findOne($this->data['coin']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function afterFind()
    {
        parent::afterFind();

        if($this->block_id == 3) {
            $this->data = Json::decode($this->text);
        }
    }
}