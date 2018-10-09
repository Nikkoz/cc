<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\blog\BlogForm */
/* @var $post \core\entities\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>

        <div class="row">
            <?= $form->field($model, 'title', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'date', ['options' => ['class' => 'col-md-6']])->widget(DatePicker::class, [
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                ]
            ]) ?>
        </div>

        <?= $form->field($model->picture, 'file')->widget(FileInput::class, [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'allowedFileExtensions'=>['jpg','gif','png', 'jpeg', 'svg'],
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  \Yii::t('app','Select icon'),
                'overwriteInitial' => false,
                'initialPreview' => [
                    isset($post->picture) ? $post->picture->getFile('blog') : ''
                ],
                'initialPreviewConfig' => isset($post->picture) ? [
                    [
                        'caption' => '',
                        'url' => "/blog/remove-picture/?id={$post->id}",
                        'key' => $post->picture->id,
                        'extra' => [
                            'id' => $post->picture->id,
                        ]
                    ]
                ] : [],
                'initialPreviewAsData'=>true,
                'fileActionSettings' => [
                    'showZoom' => false,
                    'showDrag' => false,
                    'showDelete' => false,
                ]
            ],
        ]) ?>

        <?= $form->field($model, 'coin_id')->widget(Select2::class, [
            'items' => $model->coins,
            'multiple' => false
        ]) ?>

        <div class="row">
            <?= $form->field($model, 'index', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'direction', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->rout,
                'multiple' => false
            ]) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'views', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'likes', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>

        <?= $form->field($model, 'text')->widget(Widget::class, [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'maxHeight' => 300,
                'plugins' => [
                    'clips',
                    'fullscreen',
                ],
            ],
        ]); ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

