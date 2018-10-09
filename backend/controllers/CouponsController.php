<?php

namespace backend\controllers;


use backend\forms\CouponsSearch;
use core\entities\Coupons;
use core\forms\manage\CouponsForm;
use core\services\manage\CouponManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CouponsController
 * @package backend\controllers
 *
 * @property CouponManageService $service
 */
class CouponsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, CouponManageService $service, array $config = [])
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

    public function actionIndex(): string
    {
        $searchModel = new CouponsSearch();
        $dataProbider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProbider
        ]);
    }

    public function actionCreate()
    {
        $form = new CouponsForm();

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $coupon = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Coupon created.'));
                    return $this->redirect(['/coupons']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding coupon.'));
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
        $coupon = $this->findModel($id);

        $form = new CouponsForm($coupon);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Coupon updated.'));
                    return $this->redirect(['/coupons']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating coupons.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'coin' => $coupon
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

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('/coupons'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }


    /**
     * @param int $id
     * @return Coupons
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Coupons
    {
        if (($model = Coupons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}