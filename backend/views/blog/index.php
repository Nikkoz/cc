<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Blog;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\BlogSearch */

$this->title = Yii::t('app', 'Blog');
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-4">
                        <?= Html::a(\Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <div class="box-body table__scroll">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'content' => function($model) {
                            return Html::a($model->id, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'title', 'content' => function($model) {
                            return Html::a($model->title, ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute' => 'coin_id',
                            'filter' => Blog::getCoinsFilter(),
                            'content' => function($model) {
                                return $model->coin->name ?? '';
                            }
                        ],
                        'date:date',
                        'updated_at:datetime',
                        ['attribute' => 'created_by', 'content' => function ($model) {
                            return $model->user->username;
                        }],
                        ['attribute' => 'publish', 'content' => function($model) {
                            return $model->publish ? Html::a( \Yii::t('app','Active'), [Url::toRoute(['blog/deactivate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green']) :
                                                     Html::a( \Yii::t('app','Inactive'), [Url::toRoute(['blog/activate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red']);
                        }],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

