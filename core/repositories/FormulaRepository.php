<?php

namespace core\repositories;


use core\entities\Formula;

class FormulaRepository
{
    public function get(int $id): Formula
    {
        if(!$formula = Formula::findOne($id)) {
            throw new \DomainException('Formula is not found.');
        }

        return $formula;
    }

    public function save(Formula $formula): void
    {
        if(!$formula->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Formula $formula
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Formula $formula): void
    {
        if(!$formula->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}