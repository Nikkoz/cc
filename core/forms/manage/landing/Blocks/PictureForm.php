<?php

namespace core\forms\manage\landing\blocks;

use core\entities\landing\Elements;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PictureForm
 * @package core\forms\manage\landing\blocks
 *
 * @property $file
 */
class PictureForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;

    public function __construct(Elements $element = null, array $config = [])
    {
        if ($element) {
            $this->file = $element->picture;
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
            'file' => \Yii::t('app', 'Icon'),
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