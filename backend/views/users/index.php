<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\Blog;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\UsersSearch */

$this->title = Yii::t('app', 'Users');
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
                        ['attribute' => 'name', 'content' => function($model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'email', 'content' => function($model) {
                            return Html::a($model->email, ['update', 'id' => $model->id]);
                        }],
                        ['label' => \Yii::t('app', 'Role'), 'content' => function($model) {
                            return '';
                        }],
                        ['label' => \Yii::t('app', 'Last auth'), 'content' => function($model) {
                            return '';
                        }],
                        ['label' => \Yii::t('app', 'Last activity'), 'content' => function($model) {
                            return '';
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

