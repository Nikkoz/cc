<?php

namespace core\entities\landing;


use yii\db\ActiveRecord;

/**
 * Class Blocks
 * @package core\entities\landing
 *
 * @property integer $id
 * @property string $name
 * @property string $phrase_one
 * @property string $phrase_two
 * @property string $phrase_three
 */
class Blocks extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%landing_blocks}}';
    }

    public function edit(string $phrase_one, string $phrase_two, string $phrase_three): void
    {
        $this->phrase_one = $phrase_one;
        $this->phrase_two = $phrase_two;
        $this->phrase_three = $phrase_three;
    }
}