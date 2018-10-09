<?php

namespace backend\controllers\parse;


use backend\forms\posts\FacebookSearch;
use core\entities\parse\Facebook;
use core\forms\manage\posts\FacebookForm;
use core\services\manage\posts\FacebookManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class FacebookController
 * @package backend\controllers\parse
 *
 * @property FacebookManageService $service
 */
class FacebookController extends Controller
{
    private $service;

    public function __construct(string $id, $module, FacebookManageService $service, array $config = [])
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
        $searchModel = new FacebookSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new FacebookForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $post = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Facebook post created.'));
                    return $this->redirect(['/facebook']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding facebook post.'));
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
        $post = $this->findModel($id);

        $form = new FacebookForm($post);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($post->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Facebook post updated.'));
                    return $this->redirect(['/facebook']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating facebook post.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'post' => $post
        ]);
    }

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('/facebook'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Facebook
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Facebook
    {
        if (($model = Facebook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}