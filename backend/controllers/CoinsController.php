<?php

namespace backend\controllers;

use backend\forms\CoinsSearch;
use core\entities\coins\Coins;
use core\forms\manage\coins\CoinsCreateForm;
use core\forms\manage\coins\CoinsEditForm;
use core\services\manage\coins\CoinsManageService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CoinsController
 * @package backend\controllers
 *
 * @property CoinsManageService $service
 */
class CoinsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, CoinsManageService $service, $config = array())
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'remove-picture' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index', 'create', 'update', 'delete', 'remove-picture', 'activate', 'deactivate'
                        ],
                        'allow' => true,
                        'roles' => ['adminPermission'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                }
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CoinsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $form = new CoinsCreateForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $coin = $this->service->create($form);

                    Yii::$app->session->setFlash('success', Yii::t('app', 'Coin created.'));
                    return $this->redirect(['/coins']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error adding coin.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
            'coin' => new Coins()
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $coin = $this->findModel($id);

        $form = new CoinsEditForm($coin);

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    Yii::$app->session->setFlash('success', Yii::t('app', 'Coin updated.'));
                    return $this->redirect(['/coins']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error updating coin.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'coin' => $coin
        ]);
    }

    public function actionActivate(int $id): Response
    {
        $backUrl = \Yii::$app->request->get('backUrl');

        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect([$backUrl]);
    }

    public function actionDeactivate(int $id): Response
    {
        $backUrl = \Yii::$app->request->get('backUrl');

        try {
            $this->service->deactivate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect([$backUrl]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionRemovePicture(int $id): bool
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $this->service->removePicture($id);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }

        return false;
    }

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('coins/index'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Coins
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Coins
    {
        if (($model = Coins::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}