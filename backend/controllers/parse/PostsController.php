<?php

namespace backend\controllers\parse;


use backend\forms\posts\PostsSearch;
use core\entities\parse\Posts;
use core\forms\manage\posts\PostsForm;
use core\services\manage\posts\PostsManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PostsController
 * @package backend\controllers\parse
 *
 * @property PostsManageService $service
 */
class PostsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, PostsManageService $service, array $config = [])
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
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new PostsForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $post = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Post created.'));
                    return $this->redirect(['/posts']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding post.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $post = $this->findModel($id);

        $form = new PostsForm($post);

        if ($form->load(\Yii::$app->request->post())) {

            if ($form->validate()) {
                try {
                    $this->service->edit($post->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Post updated.'));
                    return $this->redirect(['/posts']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating post.'));
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

            $this->redirect(Url::toRoute('/posts'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function actionActivate(int $id)
    {
        $backUrl = \Yii::$app->request->get('backUrl');

        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect([$backUrl]);
    }

    public function actionDeactivate(int $id)
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
     * @return Posts|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}