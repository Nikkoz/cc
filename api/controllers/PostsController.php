<?php

namespace api\controllers;


use core\helpers\PostsHelper;
use core\readModels\PostsReadRepository;
use yii\rest\Controller;

/**
 * Class PostsController
 * @package api\controllers
 *
 * @property PostsReadRepository $repository
 */
class PostsController extends Controller
{
    private $repository;

    public function __construct(string $id, $module, PostsReadRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
    }

    public function actionList(int $id)
    {
        return PostsHelper::serializeForApi($this->repository->findByCoin($id,20));
    }

    public function actionDetail(int $id)
    {
        return PostsHelper::serializeForApi([$this->repository->find($id)])[$id];
    }
}