<?php

namespace backend\controllers\parse;


use backend\forms\posts\TwitterSearch;
use core\entities\parse\Twitter;
use core\forms\manage\posts\TwitterForm;
use core\services\manage\posts\TwitterManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class TwitterController
 * @package backend\controllers\parse
 *
 * @property TwitterManageService $service
 */
class TwitterController extends Controller
{
    private $service;

    public function __construct(string $id, $module, TwitterManageService $service, array $config = [])
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
                        'actions' => ['index', 'create', 'update', 'delete'],
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
        $searchModel = new TwitterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new TwitterForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $twit = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Twitter post created.'));
                    return $this->redirect(['/twitter']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding twitter post.'));
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
        $twit = $this->findModel($id);

        $form = new TwitterForm($twit);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($twit->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Twitter post updated.'));
                    return $this->redirect(['/twitter']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating twitter post.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'post' => $twit
        ]);
    }

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('/twitter'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Twitter|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id)
    {
        if (($model = Twitter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}