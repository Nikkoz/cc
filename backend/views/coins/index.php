<?php

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\CoinsSearch */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Coins');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Coins')];
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
                        'id',
                        ['attribute' => 'name', 'content' => function($model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute' => '',
                            'content' => function($model) {
                                $result = [];
                                foreach($model->assignmentsSocials as $social) {
                                    if(count($result) == 3)
                                        break;

                                    switch ($social->type) {
                                        case 1:
                                            $type = "Twitter";
                                            break;
                                        case 2:
                                            $type = "Facebook";
                                            break;
                                        case 3:
                                            $type = "Reddit";
                                            break;
                                    }

                                    $result[$social->type] = $type . ': Да';
                                }

                                if(!empty($model->forums)) {
                                    $result[] = "BitcoinTalk: Да";
                                }

                                return implode("<br />", $result);
                            },
                            'label' => \Yii::t('app', 'Socials')
                        ],
                        [
                            'attribute' => 'type',
                            'filter' => ['Coin', 'Token'],
                            'content' => function ($model) {
                                return $model->getTypes()[$model->type];
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                        ['attribute' => 'created_by', 'content' => function ($model) {
                            return $model->user->username;
                        }],
                        ['attribute' => 'publish', 'content' => function($model) {
                            return $model->publish ? Html::a(\Yii::t('app','Active'), ['coins/deactivate', 'id' => $model->id, 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green', 'data-publish' => '']) :
                                                     Html::a(\Yii::t('app','Inactive'), ['coins/activate', 'id' => $model->id, 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red', 'data-publish' => '']);
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