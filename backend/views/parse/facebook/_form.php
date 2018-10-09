<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\Select2;
use yii\helpers\Url;
use vova07\imperavi\Widget;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\FacebookForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $is string */

$post_id = explode('_', $model->post_id);
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Твит</h3>
                <?php if ($is != 'create') : ?>
                    <div class="post_link">(<?= Html::a('Посмотреть', Url::to("https://www.facebook.com/{$model->page_name}/posts/{$post_id[1]}"), ['target' => '_blank'])?>)</div>
                <?php endif;?>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'post_id')->textInput() ?>

                <?= $form->field($model, 'coin_id')->widget(Select2::class, [
                    'items' => $model->coins,
                    'multiple' => false
                ]); ?>

                <?= $form->field($model, 'text')->widget(Widget::class,[
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'maxHeight' => 200,
                        'plugins' => [
                            'clips',
                            'fullscreen',
                        ],
                    ],
                ]); ?>

                <?= $form->field($model, 'created')->widget(DatePicker::class,[
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose'=>true,
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Пользователь</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?= $form->field($model->user, 'user_id', ['options' => ['class' => 'col-md-6']])->textInput() ?>

                    <?= $form->field($model->user, 'user_name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Отклики</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <?= $form->field($model->responses, 'shares_count', ['options' => ['class' => 'col-md-4']])->textInput() ?>

                    <?= $form->field($model->responses, 'likes_count', ['options' => ['class' => 'col-md-4']])->textInput() ?>

                    <?= $form->field($model->responses, 'comments_count', ['options' => ['class' => 'col-md-4']])->textInput() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box">
            <div class="box-footer">
                <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>