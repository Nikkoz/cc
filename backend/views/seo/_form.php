<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\SeoForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

