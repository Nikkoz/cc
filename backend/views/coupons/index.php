<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\CouponsSearch */

$this->title = \Yii::t('app', 'Coupons');
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
                        ['attribute' => 'code', 'content' => function($model) {
                            return Html::a($model->code, ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute' => 'type',
                            'filter' => [\Yii::t('app', 'Register'), \Yii::t('app', 'Discount')],
                            'content' => function($model) {
                                return $model->types[$model->type];
                            }
                        ],
                        'created_at:datetime',
                        ['attribute' => 'created_by', 'content' => function($model) {
                            return $model->user->username;
                        }],
                        [
                            'attribute' => 'publish',
                            'filter' => [\Yii::t('app', 'No'), \Yii::t('app', 'Yes')],
                            'content' => function($model) {
                                return $model->publish ? Html::a( \Yii::t('app','Active'), [Url::toRoute(['coupons/deactivate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green']) :
                                                         Html::a( \Yii::t('app','Inactive'), [Url::toRoute(['coupons/activate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red']);
                            }
                        ],
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
