<?php

namespace core\forms\manage\coins;


use yii\base\Model;
use core\entities\coins\Coins;
use core\entities\algorithms\Encryption;
use core\entities\algorithms\Consensus;
use yii\helpers\ArrayHelper;

/**
 * @property integer $smart_contracts
 * @property string $platform
 * @property string $date_start
 * @property integer $encryption_id
 * @property integer $consensus_id
 * @property integer $mining
 * @property string $max_supply
 * @property string $key_features
 * @property string $use
 */
class DataForm extends Model
{
    public $smart_contracts;
    public $platform;
    public $date_start;
    public $encryption_id;
    public $consensus_id;
    public $mining;
    public $max_supply;
    public $key_features;
    public $use;

    public function __construct(Coins $coin = null, $config = array())
    {
        if($coin) {
            $this->smart_contracts = $coin->smart_contracts;
            $this->platform = $coin->platform;
            $this->date_start = $coin->date_start;
            $this->encryption_id = $coin->encryption_id;
            $this->consensus_id = $coin->consensus_id;
            $this->mining = $coin->mining;
            $this->max_supply = $coin->max_supply;
            $this->key_features = $coin->key_features;
            $this->use = $coin->use;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['smart_contracts', 'encryption_id', 'consensus_id', 'mining', 'max_supply'], 'integer'],
            [['platform', 'date_start'], 'string', 'max' => 255],
            [['key_features', 'use'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'smart_contracts' => \Yii::t('app', 'Smart contracts'),
            'platform' => \Yii::t('app', 'Platform'),
            'date_start' => \Yii::t('app', 'Date start'),
            'encryption_id' => \Yii::t('app', 'Encryption algorithm'),
            'consensus_id' => \Yii::t('app', 'Consensus algorithm'),
            'mining' => \Yii::t('app', 'Mining'),
            'max_supply' => \Yii::t('app', 'Max supply'),
            'key_features' => \Yii::t('app', 'Key features'),
            'use' => \Yii::t('app', 'Use'),
        ];
    }

    public function algorithmEncryptionList(): array
    {
        return ArrayHelper::map(Encryption::find()->asArray()->all(), 'id', 'name');
    }

    public function algorithmConsensusList(): array
    {
        return ArrayHelper::map(Consensus::find()->asArray()->all(), 'id', 'name');
    }
}