<?php

namespace core\entities;


use yii\db\ActiveRecord;

/**
 * Class Seo
 * @package core\entities
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Seo extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%seo}}';
    }

    public static function create(string $name, string $alias, string $seo_title, string $seo_keywords, string $seo_description): self
    {
        $seo = new static();

        $seo->name = $name;
        $seo->alias = $alias;
        $seo->seo_title = $seo_title;
        $seo->seo_keywords = $seo_keywords;
        $seo->seo_description = $seo_description;

        return $seo;
    }

    public function edit(string $name, string $alias, string $seo_title, string $seo_keywords, string $seo_description): void
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->seo_title = $seo_title;
        $this->seo_keywords = $seo_keywords;
        $this->seo_description = $seo_description;
    }
}