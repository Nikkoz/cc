<?php

namespace core\entities\manage;


use core\entities\parse\PostEntities;
use core\entities\User;
use core\helpers\GradeHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Grade
 * @package core\entities\parse
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $vote_type
 * @property string $vote_val
 *
 * @property User $user
 * @property PostEntities $post
 */
class Grade extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%vote}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ]
        ];
    }

    public static function create(int $user_id, int $post_id, string $vote_type, string $vote_val): self
    {
        $grade = new static();

        $grade->user_id = $user_id;
        $grade->post_id = $post_id;
        $grade->vote_type = $vote_type;
        $grade->vote_val = $vote_val;

        return $grade;
    }

    public function edit(int $user_id, int $post_id, string $vote_type, string $vote_val): void
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->vote_type = $vote_type;
        $this->vote_val = $vote_val;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasOne(PostEntities::class, ['id', 'post_id']);
    }

    public function getGrade(): ?string
    {
        return GradeHelper::returnGrade($this->vote_type, $this->vote_val);
    }
}