<?php
namespace core\entities\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class JsonBehavior extends Behavior
{
    public $attribute = 'attr';

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

        if(is_array($this->attribute)) {
            foreach ($this->attribute as $attr) {
                $sender->$attr = Json::decode($sender->getAttribute($attr));
            }
        } else {
            $sender->{$this->attribute} = Json::decode($sender->getAttribute($this->attribute));
        }
    }
    public function onBeforeSave(Event $event)
    {
        $sender = $event->sender;

        if(is_array($this->attribute)) {
            foreach ($this->attribute as $attr) {
                $sender->setAttribute($attr, Json::encode($sender->$attr));
            }
        } else {
            $sender->setAttribute($this->attribute, Json::encode($sender->{$this->attribute}));
        }
    }
}