<?php

namespace backend\controllers\algorithm;


use backend\forms\algorithm\EncryptionSearch;
use core\entities\algorithms\Encryption;
use core\forms\manage\algorithm\EncryptionForm;
use core\services\manage\algorithm\EncryptionManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class EncryptionController
 * @package backend\controllers\algorithm
 *
 * @property EncryptionManageService $service
 */
class EncryptionController extends Controller
{
    private $service;

    public function __construct(string $id, $module, EncryptionManageService $service, array $config = [])
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
        $searchModel = new EncryptionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new EncryptionForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $encryption = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Algorithm encryption created.'));
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding algorithm encryption.'));
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
        $encryption = $this->findModel($id);

        $form = new EncryptionForm($encryption);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Algorithm encryption updated.'));
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating algorithm encryption.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'coin' => $encryption
        ]);
    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(['index']);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Encryption
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): Encryption
    {
        if (($model = Encryption::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}