<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use core\helpers\PostsHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\TwitterSearch */

$this->title = \Yii::t('app', 'Sentiments twitter');
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
                        ['attribute' => '', 'label' => \Yii::t('app', 'Coin'), 'content' => function ($model) {
                            return isset($model->coin) ? $model->coin->name : PostsHelper::returnCoins($model->handbooks);
                        }],
                        ['attribute' => 'text', 'content' => function($model) {
                            return StringHelper::truncate(strip_tags($model->text), 70, '...', 'UTF-8', 'false') .
                                ' (' . Html::a(\Yii::t('app', 'Source'), Url::to(PostsHelper::returnTwitterLink($model->page_name, $model->post_id))) . ')';
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