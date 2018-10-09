<?php

namespace core\entities\parse;


use core\entities\behaviors\DateBehavior;
use core\entities\coins\handbook\Handbook;
use core\entities\coins\handbook\HandbookAssignments;
use core\entities\Sites;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Posts
 * @package core\entities
 *
 * @property string $title
 * @property string $link
 * @property string $section
 * @property integer $created
 * @property integer $publish
 * @property string $text
 * @property string $type
 * @property integer $site_id
 *
 * @property Handbook[] $handbooks
 * @property Sites[] $siteData
 *
 * @property HandbookAssignments $handbookAssignments
 */
class Posts extends PostEntities
{
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
            ], [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'handbookAssignments'
                ]
            ]
        ];
    }

    public static function create(string $title, string $link, string $section, string $created, int $publish, string $text): self
    {
        $post = new static();

        $post->title = $title;
        $post->link = $link;
        $post->section = $section;
        $post->created = $created;
        $post->publish = $publish;
        $post->text = $text;

        $post->type = 'post';

        return $post;
    }

    public function edit(string $title, string $link, string $section, string $created, int $publish, string $text): void
    {
        $this->title = $title;
        $this->link = $link;
        $this->section = $section;
        $this->created = $created;
        $this->publish = $publish;
        $this->text = $text;

        $this->type = 'post';
    }

    public function rules(): array
    {
        return [
            ['site_id', 'integer'],
        ];
    }

    // site

    public function assignSite(int $id): void
    {
        $this->site_id = $id;
    }

    // Handbook

    public function assignHandbook(int $id): void
    {
        $assignments = $this->handbookAssignments;

        foreach ($assignments as $assignment) {
            if ($assignment->isForHandbook($id)) {
                return;
            }
        }

        $assignments[] = HandbookAssignments::create($id);
        $this->handbookAssignments = $assignments;
    }

    public function revokeHandbook(int $id): void
    {
        $assignments = $this->handbookAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForHandbook($id)) {
                unset($assignments[$i]);
                $this->handbookAssignments = $assignments;
                return;
            }
        }

        throw new \DomainException('Assignment is not found.');
    }

    public function revokeHandbooks(): void
    {
        $this->handbookAssignments = [];
    }

    //assignments

    public function getSite(): ActiveQuery
    {
        return $this->hasOne(Sites::class, ['id' => 'site_id']);
    }
}