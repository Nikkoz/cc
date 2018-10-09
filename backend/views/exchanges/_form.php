<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ExchangesForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <?= $form->field($model, 'type', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->types,
                'multiple' => false
            ]) ?>

            <?= $form->field($model, 'link', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>

        <?= $form->field($model, 'description')->widget(Widget::class, [
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

