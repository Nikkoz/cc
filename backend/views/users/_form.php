<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\UsersForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>

        <?= $form->field($model, 'role')->widget(Select2::class, [
            'items' => $model->roles,
            'multiple' => false,
        ]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

