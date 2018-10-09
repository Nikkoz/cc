<?php

namespace core\forms\manage;


use core\entities\Seo;
use yii\base\Model;

/**
 * Class SeoForm
 * @package core\forms\manage
 *
 * @property string $name
 * @property string $alias
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 *
 * @property Seo $_seo
 */
class SeoForm extends Model
{
    public $name;
    public $alias;
    public $seo_title;
    public $seo_keywords;
    public $seo_description;

    private $_seo;

    public function __construct(Seo $seo = null, array $config = [])
    {
        if ($seo) {
            $this->name = $seo->name;
            $this->alias = $seo->alias;
            $this->seo_title = $seo->seo_title;
            $this->seo_keywords = $seo->seo_keywords;
            $this->seo_description = $seo->seo_description;

            $this->_seo = $seo;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'alias'], 'required'],
            ['alias', 'unique', 'targetClass' => Seo::class, 'filter' => $this->_seo ? ['<>', 'id', $this->_seo->id] : null],
            [['name', 'alias', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            ['seo_description', 'string'],
        ];
    }
}