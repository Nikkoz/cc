<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\CouponsForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <?= $form->field($model, 'type', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->types,
                'multiple' => false
            ]) ?>

            <?= $form->field($model, 'discount', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

