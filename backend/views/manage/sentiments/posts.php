<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use core\helpers\PostsHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\PostsSearch */

$this->title = \Yii::t('app', 'Sentiments posts');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Manage'), 'url' => Url::toRoute(['sentiments/posts'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body table__scroll">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'title', 'content' => function($model) {
                            return Html::a(StringHelper::truncate($model->title, 75, '...', 'UTF-8', false), Url::to($model->link), ['target' => '_blank']);
                        }],
                        ['attribute' => 'handbook', 'label' => \Yii::t('app', 'Coins'), 'content' => function($model){
                            return PostsHelper::returnCoins($model->handbooks);
                        }],
                        ['attribute' => 'site', 'label' => \Yii::t('app', 'Site'), 'content' => function($model) {
                            return $model->site->name;
                        }],
                        ['attribute' => 'sentiment', 'label' => \Yii::t('app', 'Sentiment'), 'content' => function($model) {
                            return $model->sense;
                        }],
                        ['attribute' => 'sentiment_num','label' => \Yii::t('app', 'Coefficient')],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>