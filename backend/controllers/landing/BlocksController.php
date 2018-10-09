<?php

namespace backend\controllers\landing;


use core\entities\landing\Blocks;
use core\entities\landing\Elements;
use core\forms\manage\landing\blocks\BlocksForm;
use core\forms\manage\landing\Blocks\ElementFourForm;
use core\forms\manage\landing\Blocks\ElementSixForm;
use core\forms\manage\landing\Blocks\ElementThreeForm;
use core\forms\manage\landing\Blocks\ElementTwoForm;
use core\services\manage\landing\BlocksManageService;
use core\services\manage\landing\ElementsManageService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BlocksController
 * @package backend\controllers\landing
 *
 * @property BlocksManageService $service
 * @property ElementsManageService $elementService
 */
class BlocksController extends Controller
{
    private $service;
    private $elementService;

    public function __construct(string $id, $module, BlocksManageService $service, ElementsManageService $elementService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->elementService = $elementService;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-settings' => ['POST'],
                    'remove-picture' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'form', 'update', 'create-settings', 'update-settings', 'delete-settings', 'remove-picture'],
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
        $blocks = Blocks::find()->indexBy('id')->all();

        $block_id = \Yii::$app->request->get('block_id') ?: 1;
        $form = new BlocksForm($blocks[$block_id]);

        //if($block_id != 1) {
        $dataProvider = new ActiveDataProvider([
            'query' => Elements::find()->where(['=', 'block_id', $block_id]),
        ]);
        //}

        return $this->render('index', [
            'model' => $form,
            'blocks' => $blocks,
            'selected' => $blocks[$block_id],
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionForm()
    {
        $id = \Yii::$app->request->get('id');

        $block = $this->findModel($id);
        $form = new BlocksForm($block);

        $dataProvider = new ActiveDataProvider([
            'query' => Elements::find()->where(['=', 'block_id', $id]),
        ]);

        return $this->renderAjax('_form', [
            'model' => $form,
            'block' => $block,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $block = $this->findModel($id);

        $form = new BlocksForm($block);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Block updated.'));
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating block.'));
            }
        }

        return $this->renderPartial('_form', [
            'model' => $form,
            'block' => $block
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateSettings()
    {
        $block_id = \Yii::$app->request->get('block_id');
        $form = $this->setForm($block_id);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $element = $this->elementService->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Element created.'));

                    return $this->redirect("/landing/blocks/?block_id={$block_id}");
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error creating element.'));
            }
        }

        return $this->render('_create', [
            'model' => $form,
            'block_id' => $block_id,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateSettings(int $id)
    {
        $element = $this->findModelElements($id);
        $form = $this->setForm($element->block_id, $element);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->elementService->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Element updated.'));

                    return $this->redirect("/landing/blocks/?block_id={$element->block_id}");
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating element.'));
            }
        }

        return $this->render('_update', [
            'model' => $form,
            'element' => $element,
        ]);
    }

    public function actionDeleteSettings(int $id)
    {
        try {
            $block_id = $this->elementService->getBlock($id);
            $this->elementService->remove($id);

            $this->redirect(Url::toRoute("/landing/blocks/?block_id={$block_id}"));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionRemovePicture(int $id): bool
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $this->elementService->removePicture($id);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }

        return false;
    }

    /**
     * @param int $block_id
     * @param Elements|null $element
     * @return ElementFourForm|ElementSixForm|ElementThreeForm|ElementTwoForm
     * @throws NotFoundHttpException
     */
    protected function setForm(int $block_id, Elements $element = null)
    {
        switch ($block_id) {
            case 2:
                return new ElementTwoForm($element);
                break;
            case 3:
                return new ElementThreeForm($element);
                break;
            case 4:
                return new ElementFourForm($element);
                break;
            case 6:
            case 7:
                return new ElementSixForm($element);
                break;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $id
     * @return Blocks
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Blocks
    {
        if (($model = Blocks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param int $id
     * @return Elements
     * @throws NotFoundHttpException
     */
    protected function findModelElements(int $id): Elements
    {
        if (($model = Elements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}