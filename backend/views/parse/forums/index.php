<?php

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\ForumsSearch */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

$this->title = \Yii::t('app', 'Forums message');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Parse'), 'url' => ['/posts']];
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
                        [
                            'attribute' => 'forum_id',
                            'content' => function($model) {
                                return $model->forums[$model->forum_id];
                            }
                        ],
                        ['attribute' => 'text', 'content' => function($model) {
                            return StringHelper::truncate($model->text, 70, '...', 'UTF-8', false);
                        }],
                        'date:datetime',
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
