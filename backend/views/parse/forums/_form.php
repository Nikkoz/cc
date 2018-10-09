<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\ForumsForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <div class="row">
            <?= $form->field($model, 'forum_id', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->forums,
                'multiple' => false
            ]) ?>

            <?= $form->field($model, 'user_name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>

        <?= $form->field($model, 'date')->widget(DatePicker::class, [
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
                'autoclose' => true,
            ]
        ]) ?>

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

