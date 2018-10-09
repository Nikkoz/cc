<?php

namespace core\forms\manage\blog;

use core\entities\Blog;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PictureForm
 * @package core\forms\manage\blog
 *
 * @property $file
 */
class PictureForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;

    public function __construct(Blog $post = null, array $config = [])
    {
        if ($post) {
            $this->file = $post->picture;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['file'], 'file'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'file' => \Yii::t('app', 'Picture'),
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {

            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }
}