<?php

namespace backend\controllers;


use core\entities\coins\Coins;
use core\entities\Formula;
use core\entities\Sites;
use core\forms\manage\FormulaForm;
use core\helpers\PostsHelper;
use core\services\manage\FormulaManageService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class FormulaController
 * @package backend\controllers
 *
 * @property FormulaManageService $service
 */
class FormulaController extends Controller
{
    private $service;

    public function __construct(string $id, $module, FormulaManageService $service, array $config = [])
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
                        'actions' => ['index', 'coin'],
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
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $formula = $this->findModel(1);

        $coins = Coins::find()->cache(1000)->all();
        $sites = Sites::find()->cache(1000)->count();

        $form = new FormulaForm($formula);

        if ($form->load(\Yii::$app->request->post())) {
            if ($form->validate()) {
                try {
                    $this->service->edit(1, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Formula updated.'));
                    return $this->redirect(['/formula']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating formula.'));
            }
        }

        return $this->render('index', [
            'model' => $form,
            'coins' => $coins,
            'sites' => $sites,
            'posts' => PostsHelper::getPosts($coins[0]->id)
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCoin(): string
    {
        $coin = \Yii::$app->request->get('coin');
        $type = \Yii::$app->request->get('type');

        $formula = $this->findModel(1);

        $params = [];

        switch ($type) {
            case '1':
                $params = [
                    'sites' => Sites::find()->count(),
                    'count' => PostsHelper::getPosts($coin)['count'],
                ];
                break;
            case '2':
                $facebook = PostsHelper::getFacebookPosts($coin);
                $twitter = PostsHelper::getTwitterPosts($coin);
                $reddit = PostsHelper::getRedditPosts($coin);
                $forums = PostsHelper::getForums($coin);

                $count = intval($facebook['shares'] + $facebook['likes'] + $facebook['comments']);
                $count += intval($twitter['shares'] + $twitter['likes'] + $twitter['comments']);
                $count += intval($reddit['likes'] + $reddit['comments']);
                if (!empty($forums['community'])) {
                    $count += array_sum($forums['community']);
                }

                $params = [
                    'count' => $count
                ];
                break;
            case '3':
                $facebook = PostsHelper::getFacebookPosts($coin);
                $twitter = PostsHelper::getTwitterPosts($coin);
                $forums = PostsHelper::getForums($coin);

                $count = $facebook['count'] + $twitter['count'];
                if (!empty($forums['developers'])) {
                    $count += array_sum($forums['developers']);
                }
                $params = [
                    'count' => $count
                ];
                break;
            case '4':
                $params = [
                    'count' => PostsHelper::getTwitterExchange($coin)['count'] + PostsHelper::getFacebookExchange($coin)['count'] + PostsHelper::getRedditExchange($coin)['count']
                ];
                break;
        }

        return $this->render('coin', array_merge(['formula' => $formula, 'type' => $type], $params));
    }

    /**
     * @param $id
     * @return Formula|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Formula
    {
        if (($model = Formula::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}