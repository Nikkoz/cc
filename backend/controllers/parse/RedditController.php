<?php

namespace backend\controllers\parse;


use backend\forms\posts\RedditSearch;
use core\entities\parse\Reddit;
use core\forms\manage\posts\RedditForm;
use core\services\manage\posts\RedditManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class RedditController
 * @package backend\controllers\parse
 *
 * @property RedditManageService $service
 */
class RedditController extends Controller
{
    private $service;

    public function __construct(string $id, $module, RedditManageService $service, array $config = [])
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
        $searchModel = new RedditSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new RedditForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $post = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Reddit post created.'));
                    return $this->redirect(['/reddit']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding reddit post.'));
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

        $form = new RedditForm($post);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($post->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Reddit post updated.'));
                    return $this->redirect(['/reddit']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating reddit post.'));
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

            $this->redirect(Url::toRoute('/reddit'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Reddit
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Reddit
    {
        if (($model = Reddit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}