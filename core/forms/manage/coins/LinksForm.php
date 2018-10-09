<?php

namespace core\forms\manage\coins;


use core\entities\coins\Coins;
use yii\db\ActiveRecord;

/**
 * @property array $site
 * @property array $link
 * @property array $chat
 * @property array $source_code
 */
class LinksForm extends ActiveRecord
{
    public $site;
    public $link;
    public $chat;
    public $source_code;

    public function __construct(Coins $coin = null, $config = array())
    {
        if ($coin) {
            $this->site = $coin->site;
            $this->link = $coin->link;
            $this->chat = $coin->chat;
            $this->source_code = $coin->source_code;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['site', 'link', 'chat', 'source_code'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'site' => \Yii::t('app', 'Site'),
            'link' => \Yii::t('app', 'Link'),
            'chat' => \Yii::t('app', 'Chat'),
            'source_code' => \Yii::t('app', 'Source code'),
        ];
    }
}