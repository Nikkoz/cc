<?php

namespace core\forms\manage\algorithm;


use core\entities\algorithms\Encryption;
use yii\base\Model;

/**
 * Class EncryptionForm
 * @package core\forms\manage\algorithm
 *
 * @property string $name
 */
class EncryptionForm extends Model
{
    public $name;

    public function __construct(Encryption $encryption = null, array $config = [])
    {
        if($encryption) {
            $this->name = $encryption->name;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255]
        ];
    }
}