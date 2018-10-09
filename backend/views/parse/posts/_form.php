<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\PostsForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <?= $form->field($model, 'site', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->sitesList(),
                'multiple' => false
            ]) ?>

            <?= $form->field($model, 'link', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'section', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'created', ['options' => ['class' => 'col-md-6']])->widget(DatePicker::class, [
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                ]
            ]) ?>
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

        <?= $form->field($model->handbook, 'handbook')->widget(Select2::class, [
            'items' => $model->handbook->handbookList(),
            'multiple' => true
        ]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

