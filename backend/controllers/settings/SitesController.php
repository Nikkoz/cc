<?php

namespace backend\controllers\settings;


use backend\forms\SitesSearch;
use core\entities\Sites;
use core\forms\manage\SitesForm;
use core\services\manage\SitesManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class SitesController
 * @package backend\controllers\settings
 *
 * @property SitesManageService $service
 */
class SitesController extends Controller
{
    private $service;

    public function __construct(string $id, $module, SitesManageService $service, array $config = [])
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
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'activate', 'deactivate'],
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
        $searchModel = new SitesSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new SitesForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $site = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Site created.'));
                    return $this->redirect(['/sites']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding site.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $site = $this->findModel($id);

        $form = new SitesForm($site);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($site->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Site updated.'));
                    return $this->redirect(['/sites']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating site.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'site' => $site
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

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('/sites'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return Sites|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Sites::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}