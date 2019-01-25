<?php

namespace core\entities\coins;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Forums
 * @package core\entities\coins
 *
 * @property integer $id
 * @property integer $coin_id
 * @property string $link
 * @property string $admin
 */
class Forums extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%forum_links}}';
    }

    public static function create(string $link, string $admin): self
    {
        $forum = new static();

        $forum->link = $link;
        $forum->admin = $admin;

        return $forum;
    }

    public function edit(string $link, string $admin): void
    {
        $this->link = $link;
        $this->admin = $admin;
    }

    public function assignCoin($id): void
    {
        $this->coin_id = $id;
    }

    public function getCoin(): ActiveQuery
    {
        return $this->hasOne(Coins::class, ['id' => 'coin_id']);
    }
}