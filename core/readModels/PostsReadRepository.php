<?php

namespace core\readModels;


use core\entities\parse\Posts;

class PostsReadRepository
{
    public function find(int $id): ?Posts
    {
        return Posts::findOne(['id' => $id]);
    }

    /**
     * @param int $coin
     * @param int|null $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findByCoin(int $coin, int $limit = null): array
    {
        return Posts::find()->where(['publish' => 1, 'coin_id' => $coin])->limit($limit)->all();
    }
}