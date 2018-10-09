<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\algorithm\ConsensusForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

