<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\ExchangesSearch */
/* @var $networks \core\entities\coins\socials\Networks */

$this->title = \Yii::t('app', 'Exchanges');
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
                        [
                            'attribute' => 'type',
                            'filter' => ArrayHelper::map($networks, 'id', 'name'),
                            'content' => function($model) {
                                return $model->network->name;
                            }
                        ],
                        'created_at:datetime',
                        ['attribute' => 'created_by', 'content' => function($model) {
                            return $model->user->username;
                        }],
                        ['attribute' => 'publish', 'content' => function($model, $key, $index) {
                            return $model->publish ? Html::a( \Yii::t('app','Active'), [Url::toRoute(['exchanges/deactivate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green']) :
                                                     Html::a( \Yii::t('app','Inactive'), [Url::toRoute(['exchanges/activate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red']);
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
