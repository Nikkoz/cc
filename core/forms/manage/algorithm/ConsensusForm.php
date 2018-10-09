<?php

namespace core\forms\manage\algorithm;


use core\entities\algorithms\Consensus;
use yii\base\Model;

/**
 * Class ConsensusForm
 * @package core\forms\manage\algorithm
 *
 * @property string $name
 */
class ConsensusForm extends Model
{
    public $name;

    public function __construct(Consensus $consensus = null, array $config = [])
    {
        if ($consensus) {
            $this->name = $consensus->name;
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