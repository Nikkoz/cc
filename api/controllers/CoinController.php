<?php

namespace api\controllers;


use core\helpers\CoinHelper;
use core\readModels\CoinReadRepository;
use yii\rest\Controller;

/**
 * Class CoinController
 * @package api\controllers
 *
 * @property CoinReadRepository $repository
 */
class CoinController extends Controller
{
    private $repository;

    public function __construct(string $id, $module, CoinReadRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
    }

    public function actionIndex(string $code)
    {
        $coin = $this->repository->findActiveByCode($code);

        return CoinHelper::serializeForApi($coin);
    }
}