<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\SitesForm */
/* @var \yii\base\Model $searchModel*/

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Sites');
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
                        'id',
                        ['attribute' => 'name', 'content' => function($model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }],
                        'link',
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'publish',
                            'filter' => [\Yii::t('app', 'Inactive'), \Yii::t('app', 'Active')],
                            'content' => function($model) {
                                return $model->publish ? Html::a( \Yii::t('app','Active'), [Url::toRoute(['settings/sites/deactivate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-green']) :
                                                         Html::a( \Yii::t('app','Inactive'), [Url::toRoute(['settings/sites/activate', 'id' => $model->id]), 'backUrl' => \Yii::$app->request->url], ['class' => 'label bg-red']);
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
