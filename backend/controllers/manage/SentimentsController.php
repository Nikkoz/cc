<?php

namespace backend\controllers\manage;


use backend\forms\posts\FacebookSearch;
use backend\forms\posts\PostsSearch;
use backend\forms\posts\TwitterSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class SentimentsController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['posts', 'twitter', 'facebook'],
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

    public function actionPosts()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('posts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionTwitter()
    {
        $searchModel = new TwitterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('twitter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionFacebook()
    {
        $searchModel = new FacebookSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('facebook', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}