<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\Select2;
use vova07\imperavi\Widget;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\TabularColumn;

/* @var $this yii\web\View */
/* @var $model core\forms\manage\coins\CoinsCreateForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $coin \core\entities\coins\Coins */

$this->title = Yii::t('app', 'Create Coin');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Coins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#coin" data-toggle="tab"><?= \Yii::t('app', 'Coin');?></a>
        </li>
        <li>
            <a href="#data" data-toggle="tab"><?= \Yii::t('app', 'Data');?></a>
        </li>
        <li>
            <a href="#links" data-toggle="tab"><?= \Yii::t('app', 'Links');?></a>
        </li>
        <li>
            <a href="#handbook" data-toggle="tab"><?= \Yii::t('app', 'Handbook');?></a>
        </li>
        <li>
            <a href="#meta" data-toggle="tab"><?= \Yii::t('app', 'SEO');?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="coin">
            <div class="box-body">
                <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>

                <div class="row">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'code', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'type', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                        'items' => $model->getTypes(),
                        'multiple' => false
                    ]); ?>

                    <?= $form->field($model->picture, 'file', ['options' => ['class' => 'col-md-6']])->widget(\kartik\file\FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowedFileExtensions'=>['jpg','gif','png'],
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' =>  \Yii::t('app','Select icon'),
                            'overwriteInitial' => false,
                            'initialPreview' => [
                                //$model->getIcon()
                            ],
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
        </div>
        <div class="tab-pane" id="data">
            <?= $form->field($model->data, 'smart_contracts')->widget(Select2::class, [
                'items' => [\Yii::t('app', 'Yes'), \Yii::t('app', 'No')],
                'multiple' => false,
            ]); ?>

            <?= $form->field($model->data, 'platform')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->data, 'date_start')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->data, 'encryption_id')->widget(Select2::class, [
                'items' => $model->data->algorithmEncryptionList(),
                'multiple' => false
            ]); ?>

            <?= $form->field($model->data, 'consensus_id')->widget(Select2::class, [
                'items' => $model->data->algorithmConsensusList(),
                'multiple' => false
            ]); ?>

            <?= $form->field($model->data, 'mining')->widget(Select2::class, [
                'items' => [\Yii::t('app', 'Yes'), \Yii::t('app', 'No')],
                'multiple' => false
            ]); ?>

            <?= $form->field($model->data, 'max_supply')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model->data, 'key_features')->widget(Widget::class,[
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

            <?= $form->field($model->data, 'use')->widget(Widget::class,[
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
        </div>
        <div class="tab-pane" id="links">
            <?= $form->field($model->links, 'site')->widget(MultipleInput::class, [
                'max'               => 10,
                'min'               => 1,
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
            ])->label(false); ?>

            <?= $form->field($model->links, 'source_code')->widget(MultipleInput::class, [
                'max'               => 10,
                'min'               => 1,
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
            ])->label(false); ?>

            <?= $form->field($model->links, 'chat')->widget(MultipleInput::class, [
                'max'               => 10,
                'min'               => 1,
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
            ])->label(false); ?>

            <?= $form->field($model->links, 'link')->widget(MultipleInput::class, [
                'max'               => 10,
                'min'               => 1,
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_ROW // show add button in the header
            ])->label(false); ?>

            <?= $form->field($model->socials, 'social')->widget(MultipleInput::class, [
                'columns' => [
                    [
                        'name' => 'id',
                        'type' => TabularColumn::TYPE_HIDDEN_INPUT
                    ], [
                        'name' => 'link',
                        'title' => \Yii::t('app', 'Link'),
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ], [
                        'name' => 'type',
                        'type' => 'dropDownList',
                        'title' => \Yii::t('app', 'Service'),
                        'items' => $model->socials->getType(),
                    ], [
                        'name' => 'description',
                        'title' => \Yii::t('app', 'Description'),
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ]
                ],
            ])->label(false); ?>

            <?= $form->field($model->forums, 'schedule')->widget(MultipleInput::class, [
                'columns' => [
                    [
                        'name' => 'id',
                        'type' => TabularColumn::TYPE_HIDDEN_INPUT
                    ],
                    [
                        'name' => 'link',
                        'title' => 'bitcointalk',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                    [
                        'name' => 'admin',
                        'title' => 'Админ(Создетель темы)',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ]
                ],
            ])->label(false); ?>
        </div>
        <div class="tab-pane" id="handbook">
            <div class="box-body">
                <?= $form->field($model->handbook, 'words')->widget(MultipleInput::class, [
                    'max' => 200,
                    'columns' => [
                        [
                            'name' => 'id',
                            'type' => TabularColumn::TYPE_HIDDEN_INPUT
                        ], [
                            'name' => 'title',
                            'title' => \Yii::t('app', 'Phrase'),
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ], [
                            'name' => 'check_case',
                            'type' => TabularColumn::TYPE_CHECKBOX,
                            'title' => \Yii::t('app', 'Check case'),
                            //'items' => [\Yii::t('app', 'No'), \Yii::t('app', 'Yes')],
                        ], [
                            'name' => 'publish',
                            'type' => 'dropDownList',
                            'title' => \Yii::t('app', 'Active'),
                            'items' => [\Yii::t('app', 'No'), \Yii::t('app', 'Yes')],
                        ]
                    ]
                ])->label(false); ?>
            </div>
        </div>
        <div class="tab-pane" id="meta">
            <div class="box-body">
                <?= $form->field($model->meta, 'title')->textInput() ?>

                <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>

                <?= $form->field($model->meta, 'keywords')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
