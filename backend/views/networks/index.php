<?php

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\PostsSearch */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Networks');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Networks'), 'url' => Url::toRoute(['networks'])];
$this->params['breadcrumbs'][] = $this->title;
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
                        ['attribute' => 'name', 'content' => function($model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }],
                        'link',
                        'created_at:datetime',
                        ['attribute' => 'publish', 'content' => function($model, $key, $index) {
                            return $model->publish ? Html::a( \Yii::t('app','Active'), [Url::toRoute(['networks/deactivate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green']) :
                                                     Html::a( \Yii::t('app','Inactive'), [Url::toRoute(['networks/activate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red']);
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
