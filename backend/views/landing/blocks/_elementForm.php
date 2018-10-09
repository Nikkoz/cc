<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\widgets\Select2;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use kartik\time\TimePicker;
use unclead\multipleinput\TabularColumn;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \core\forms\manage\landing\Blocks\ElementTwoForm */
/* @var $element \core\entities\landing\Elements*/
/* @var $create boolean */

$block_id = $block_id ?: $model->block_id;
?>

<div class="box box-success">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="box-body">
        <?php if($block_id != 3) : ?>
            <?= $form->field($model, 'block_id')->hiddenInput(['value' => $block_id])->label(false) ?>

            <?php if($block_id == 2 || $block_id == 4) : ?>
                <?= $form->field($model->picture, 'file', ['options' => ['class' => '']])->widget(FileInput::class, [
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
                            !$create && $element->picture ? $element->picture->getFile('landing') : ''
                        ],
                        'initialPreviewConfig' => !$create && $element->picture ? [
                            [
                                'caption' => '',
                                'url' => "/landing/blocks/remove-picture/?id={$element->id}",
                                'key' => $element->picture->id,
                                'extra' => [
                                    'id' => $element->picture->id,
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
            <?php endif;?>

            <?= $form->field($model, 'text')->textInput(['maxlength' => true]); ?>

            <?php if(in_array($block_id, [4, 6, 7])) : ?>
                <?= $form->field($model, 'preview')->widget(Widget::class,[
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'maxHeight' => 200,
                        'plugins' => [
                            'clips',
                            'fullscreen',
                        ],
                        'buttonSource' => true,
                        'allowedTags' => ['p','div','h1','h2','h3','h4','h5','a', 'img'],
                        //'markup' => 'div',
                        'pasteKeepClass' => ['p','div'],
                        'pasteBlockTags' => [
                            'p', 'div'
                        ],
                        'replaceDivs' => false,
                        'pastePlainText' => false,
                    ],
                ]); ?>
            <?php endif;?>

        <?php else : ?>
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'block_id')->hiddenInput(['value' => $block_id])->label(false) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'coin')->widget(Select2::class, [
                                'items' => $model->coins,
                                'multiple' => false
                            ]); ?>

                            <?= $form->field($model, 'site')->textInput(['maxlength' => true]); ?>

                            <?= $form->field($model, 'growthCapitalization',[
                                'options' => ['class' => 'inline_l_i'],
                                'template' => "{label}\n{input}&nbsp;<i>%</i>\n{hint}\n{error}"
                            ])->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-md-6">
                            <?php /*= $form->field($model, 'date')->widget(DatePicker::class,[
                                'pluginOptions' => [
                                    'format' => 'dd.mm.yyyy',
                                    'autoclose'=>true,
                                ]
                            ]) */?>

                            <?= $form->field($model, 'date')->textInput(['maxlength' => true]); ?>

                            <?= $form->field($model, 'link')->textInput(['maxlength' => true]); ?>

                            <?= $form->field($model, 'type',['options' => ['class' => 'select_inline']])->widget(Select2::class, [
                                'items' => $model->types,
                                'multiple' => false
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model->picture, 'file', ['options' => ['class' => '']])->widget(FileInput::class, [
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
                                !$create && $element->picture ? $element->picture->getFile('landing') : ''
                            ],
                            'initialPreviewConfig' => !$create && $element->picture ? [
                                [
                                    'caption' => '',
                                    'url' => "/landing/blocks/remove-picture/?id={$element->id}",
                                    'key' => $element->picture->id,
                                    'extra' => [
                                        'id' => $element->picture->id,
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'blocks')->widget(MultipleInput::class, [
                        'columns' => [
                            [
                                'name' => 'id',
                                'type' => TabularColumn::TYPE_HIDDEN_INPUT
                            ], [
                                'name' => 'time',
                                'title' => \Yii::t('app', 'Time'),
                                'type' => TimePicker::class,
                                'options' => [
                                    'pluginOptions' => [
                                        'showSeconds' => false,
                                        'showMeridian' => false,
                                        'minuteStep' => 1,
                                        'secondStep' => 5,
                                    ]
                                ]
                            ], [
                                'name' => 'GWT',
                                'title' => \Yii::t('app', 'GWT +3'),
                                'type' => MultipleInputColumn::TYPE_CHECKBOX
                            ], [
                                'name' => 'text',
                                'title' => \Yii::t('app', 'Text'),
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ], [
                                'name' => 'iot',
                                'title' => \Yii::t('app', 'Index popularity'),
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ], [
                                'name' => 'type',
                                'title' => \Yii::t('app', 'Type'),
                                'type' => 'dropDownList',
                                'items' => $model->types,
                            ], [
                                'name' => 'position',
                                'title' => \Yii::t('app', 'Position'),
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ]
                        ],
                    ])->label(false); ?>
                </div>
            </div>
        <?php endif;?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>