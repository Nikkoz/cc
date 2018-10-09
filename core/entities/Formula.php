<?php

namespace core\entities;


use yii\db\ActiveRecord;

/**
 * Class Formula
 * @package core\entities
 *
 * @property integer $news_max_val
 * @property integer $news_max_count
 * @property integer $community_max_val
 * @property integer $community_max_count
 * @property integer $developers_max_val
 * @property integer $developers_max_count
 * @property integer $exchanges_max_val
 * @property integer $exchanges_max_count
 */
class Formula extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%formula}}';
    }

    public function edit(int $news_max_val, int $news_max_count, int $community_max_val, int $community_max_count, int $developers_max_val, int $developers_max_count, int $exchanges_max_val, int $exchanges_max_count): void
    {
        $this->news_max_val = $news_max_val;
        $this->news_max_count = $news_max_count;
        $this->community_max_val = $community_max_val;
        $this->community_max_count = $community_max_count;
        $this->developers_max_val = $developers_max_val;
        $this->developers_max_count = $developers_max_count;
        $this->exchanges_max_val = $exchanges_max_val;
        $this->exchanges_max_count = $exchanges_max_count;
    }
}