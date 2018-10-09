<?php

namespace backend\controllers\manage;


use backend\forms\manage\GradeSearch;
use core\services\manage\GradeManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class GradeController
 * @package backend\controllers\parse
 *
 * @property GradeManageService $service
 */
class GradeController extends Controller
{
    private $service;

    public function __construct(string $id, $module, GradeManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['adminPermission']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                }
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GradeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}