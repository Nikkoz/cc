<?php

namespace core\repositories\manage;


use core\entities\manage\Grade;

class GradeRepository
{
    public function get(int $id): Grade
    {
        if (!$grade = Grade::findOne($id)) {
            throw new \DomainException('Grade is not found.');
        }

        return $grade;
    }

    public function save(Grade $grade): void
    {
        if (!$grade->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Grade $grade): void
    {
        if (!$grade->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}