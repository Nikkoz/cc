<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use unclead\multipleinput\MultipleInput;

/* @var $model \core\forms\manage\landing\SettingsForm */
/* @var $settings \core\entities\landing\Settings */

$this->title = \Yii::t('app', 'Landing settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <div class="box-body">
                <?= $form->field($model, 'email')->widget(MultipleInput::class, [
                    'max'               => 10,
                    'min'               => 1,
                    'allowEmptyList'    => false,
                    'enableGuessTitle'  => true,
                    'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
                ])->label(false); ?>

                <?= $form->field($model, 'donate')->widget(MultipleInput::class, [
                    'columns' => [
                        [
                            'name' => 'name',
                            'title' => 'Название',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name' => 'wallet',
                            'title' => 'Кошелек',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name' => 'link',
                            'title' => 'Ссылка',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ]
                    ],
                ])->label(false); ?>
            </div>

            <div class="box-footer">
                <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


