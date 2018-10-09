<?php
namespace core\entities;

/**
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class Meta
{
    public $title;
    public $description;
    public $keywords;

    public function __construct($title, $description, $keywords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
}
