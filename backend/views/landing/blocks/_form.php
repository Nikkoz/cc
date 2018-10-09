<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $block \core\entities\landing\Blocks */
/* @var $model \core\forms\manage\landing\blocks\BlocksForm */
/* @var $dataProvider \core\entities\landing\Elements */
?>

<div class="box box-success">
    <?php $form = ActiveForm::begin([
        'action' => "/landing/blocks/update/{$block->id}",
        'options' => [
            'class' => 'form-blocks',
            'data-pjax' => true
        ]
    ]); ?>

    <div class="box-header">
        <div class="box-title"><?= $block->name; ?></div>
    </div>

    <div class="box-body">
        <?= $form->field($model, 'phrase_one')->textInput(['style' => 'display: inline-block;width: 90%;'])->label(); ?>

        <?= $form->field($model, 'phrase_two')->textInput()->label(false); ?>

        <?= $form->field($model, 'phrase_three',['options' => ['style' => 'width: 100%;']])->textInput()->label(false); ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php if(!in_array($block->id, [1, 3, 5])) :

    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
    ];

    switch ($block->id) {
        case 2:
        case 4:
            $columns[] = [
                'attribute' => 'image',
                'content' => function($model) {
                    return $model->image ? Html::img($model->picture->getFile('landing')) : '';
                }
            ];
            break;
        case 5:
            $columns[] = 'number';
            break;
    }

    $columns[] = 'text';
    $columns[] = [
        'class' => ActionColumn::class,
        'template' => '{update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', "/landing/blocks/update-settings?id={$model->id}");
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', "/landing/blocks/delete-settings?id={$model->id}");
            }
        ],
    ];
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-4">
                            <?= Html::a(\Yii::t('app', 'Create'), ['create-settings','block_id'=>$block->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
                        </div>
                    </div>
                </div>

                <div class="box-body table__scroll">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $columns
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php elseif($block->id == 3) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-4">
                            <?= Html::a(\Yii::t('app', 'Create'), ['create-settings','block_id'=>$block->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
                        </div>
                    </div>
                </div>

                <div class="box-body table__scroll">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            ['attribute' => 'image', 'content' => function($model) {
                                return $model->image ? Html::img($model->picture->getFile('landing')) : '';
                            }],
                            ['attribute' => 'coin', 'content' => function($model) {
                                return $model->coin->name;
                            }],
                            [
                                'class' => ActionColumn::class,
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', "/landing/blocks/update-settings?id={$model->id}");
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', "/landing/blocks/delete-settings?id={$model->id}");
                                    }
                                ],
                            ]
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

<?php endif;?>