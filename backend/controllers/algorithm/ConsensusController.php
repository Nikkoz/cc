<?php

namespace backend\controllers\algorithm;


use backend\forms\algorithm\ConsensusSearch;
use core\entities\algorithms\Consensus;
use core\forms\manage\algorithm\ConsensusForm;
use core\services\manage\algorithm\ConsensusManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ConsensusController
 * @package backend\controllers\algorithm
 *
 * @property ConsensusManageService $service
 */
class ConsensusController extends Controller
{
    private $service;

    public function __construct(string $id, $module, ConsensusManageService $service, array $config = [])
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
        $searchModel = new ConsensusSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new ConsensusForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $consensus = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Algorithm consensus created.'));
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding algorithm consensus.'));
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
        $consensus = $this->findModel($id);

        $form = new ConsensusForm($consensus);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Algorithm consensus updated.'));
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating algorithm consensus.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'coin' => $consensus
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
     * @return Consensus
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): Consensus
    {
        if (($model = Consensus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}