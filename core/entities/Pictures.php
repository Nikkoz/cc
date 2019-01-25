<?php
namespace core\entities;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Pictures
 * @package news\entities\posts
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $sort
 */
class Pictures extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%pictures}}';
    }

    public static function create(string $file): self
    {
        $photo = new static();
        $photo->name = $file;

        return $photo;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function getFile(string $folder)
    {
        if($this->name) {
            $path = "upload/pictures/{$folder}/" . $this->name;
            $url = str_replace(['admin.', 'api.'], '', Url::home(true));
            return $url . $path;
        }
        return false;
    }
}