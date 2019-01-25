<?php
namespace core\entities\behaviors;

use core\entities\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'json_meta';

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
        $meta = Json::decode($sender->getAttribute($this->jsonAttribute));
        $sender->{$this->attribute} = new Meta($meta['title'], $meta['description'], $meta['keywords']);
    }
    public function onBeforeSave(Event $event)
    {
        $sender = $event->sender;
        $sender->setAttribute($this->jsonAttribute, Json::encode([
            'title' => $sender->{$this->attribute}->title,
            'description' => $sender->{$this->attribute}->description,
            'keywords' => $sender->{$this->attribute}->keywords,
        ]));
    }
}