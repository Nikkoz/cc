<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use core\helpers\GradeHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\manage\GradeSearch */

$this->title = \Yii::t('app', 'Grade');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Manage'), 'url' => Url::toRoute(['grade'])];
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
                        ['attribute' => 'user_id', 'content' => function($model) {
                            return Html::a($model->user->email, ['users/update','id'=>$model->user->id]);
                        }],
                        ['attribute' => 'post_id', 'content' => function($model) {
                            return $model->post->type . ' / ' . Html::a($model->post->headline, ["{$model->post->type}/update",'id'=>$model->post->id]);
                        }],
                        [
                            'attribute' => '',
                            'label' => \Yii::t('app', 'Coin'),
                            'content' => function($model) {
                                if($model->post->coin_id != 0) {
                                    return $model->post->coin->name;
                                } else {
                                    $coins = [];
                                    foreach($model->post->handbooks as $handbook) {
                                        $coins[$handbook->coin->id] = $handbook->coin->name;
                                    }
                                    return implode(', ', $coins);
                                }
                            }
                        ],
                        'created_at:datetime',
                        [
                            'attribute' => 'vote_type',
                            'content' => function($model) {
                                return $model->grade;
                            },
                            'filter' => GradeHelper::returnFilterVote(),
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>