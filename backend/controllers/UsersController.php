<?php

namespace backend\controllers;


use backend\forms\UsersSearch;
use core\entities\User;
use core\forms\manage\UsersForm;
use core\services\manage\UsersService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class UsersController
 * @package backend\controllers
 *
 * @property UsersService $service
 */
class UsersController extends Controller
{
    private $service;

    public function __construct(string $id, $module, UsersService $service, array $config = [])
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
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['adminPermission']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $form = new UsersForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $user = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'User created.'));
                    return $this->redirect(['/users']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error create user.'));
            }
        }

        return $this->render('create', [
            'model' => $form
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdate(int $id)
    {
        $user = $this->findModel($id);

        $form = new UsersForm($user);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'User updated.'));
                    return $this->redirect(['/users']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error update user.'));
            }
        }

        return $this->render('update', [
            'model' => $form
        ]);
    }

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(['/users']);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}