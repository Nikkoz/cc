<?php

namespace backend\controllers\landing;


use core\entities\landing\Settings;
use core\forms\manage\landing\SettingsForm;
use core\services\manage\landing\SettingsManageService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class SettingsController
 * @package backend\controllers\landing
 *
 * @property SettingsManageService $service
 */
class SettingsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, SettingsManageService $service, array $config = [])
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
                        'actions' => ['index'],
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

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $settings = $this->findModel(1);

        $form = new SettingsForm($settings);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit(1, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Settings updated.'));
                    return $this->redirect(['landing/settings']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating settings.'));
            }
        }

        return $this->render('index', [
            'model' => $form,
            'settings' => $settings
        ]);
    }

    /**
     * @param int $id
     * @return Settings
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Settings
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}