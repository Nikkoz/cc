<?php
namespace core\entities\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class DateBehavior extends Behavior
{
    public $attribute = 'date';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event)
    {
        $sender = $event->sender;

        $sender->{$this->attribute} = \Yii::$app->formatter->asDate($sender->{$this->attribute}, 'php:d.m.Y H:i');
    }
    public function onBeforeSave(Event $event)
    {
        $sender = $event->sender;

        $sender->setAttribute($this->attribute, \Yii::$app->formatter->asTimestamp($sender->getAttribute($this->attribute)));
    }
}