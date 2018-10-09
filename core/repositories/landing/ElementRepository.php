<?php

namespace core\repositories\landing;


use core\entities\landing\Elements;

class ElementRepository
{
    public function get(int $id): Elements
    {
        if(!$element = Elements::findOne($id)) {
            throw new \DomainException('Element is not found.');
        }

        return $element;
    }

    public function save(Elements $element): void
    {
        if(!$element->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Elements $element): void
    {
        if(!$element->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}