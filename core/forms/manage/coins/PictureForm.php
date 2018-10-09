<?php

namespace core\forms\manage\coins;

use core\entities\coins\Coins;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PictureForm
 * @package core\forms\namage\coins
 *
 * @property $file
 */
class PictureForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;

    public function __construct(Coins $coin = null, array $config = [])
    {
        if ($coin) {
            $this->file = $coin->picture;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['file'], 'image'],
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