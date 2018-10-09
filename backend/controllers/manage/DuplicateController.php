<?php

namespace backend\controllers\manage;


//use backend\forms\manage\DuplicateSearch;
use core\entities\manage\Duplicate;
use core\services\manage\DuplicateManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DuplicateController
 * @package backend\controllers\manage
 *
 * @property DuplicateManageService $service
 */
class DuplicateController extends Controller
{
    private $service;

    public function __construct(string $id, $module, DuplicateManageService $service, array $config = [])
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
        /*$searchModel = new DuplicateSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);*/
        $model = Duplicate::find()->orderBy(['time_up' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $model,
            /*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider*/
        ]);
    }
}