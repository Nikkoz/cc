<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\FormulaForm */
/* @var $coins \core\entities\coins\Coins */
/* @var $sites integer */
/* @var $posts \core\entities\parse\Posts */

$this->title = \Yii::t('app', 'Formula settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="formula-block">
    <h4><?= \Yii::t('app', 'Default settings'); ?></h4>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header">
                    <div class="box-title"><?= \Yii::t('app', 'Mass media')?></div>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'news_max_val',[
                        'template' => "{label}\n{input}<i class=\"persent\">%</i>\n{hint}\n{error}",
                    ])->textInput(['style'=>'width:100px']); ?>

                    <?= $form->field($model, 'news_max_count')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header">
                    <div class="box-title"><?= \Yii::t('app', 'Community')?></div>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'community_max_val',[
                        'template' => "{label}\n{input}<i class=\"persent\">%</i>\n{hint}\n{error}",
                    ])->textInput(['style'=>'width:100px']); ?>

                    <?= $form->field($model, 'community_max_count')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header">
                    <div class="box-title"><?= \Yii::t('app', 'Developers')?></div>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'developers_max_val',[
                        'template' => "{label}\n{input}<i class=\"persent\">%</i>\n{hint}\n{error}",
                    ])->textInput(['style'=>'width:100px']); ?>

                    <?= $form->field($model, 'developers_max_count')->textInput(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-success">
                <div class="box-header">
                    <div class="box-title"><?= \Yii::t('app', 'Exchanges')?></div>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'exchanges_max_val',[
                        'template' => "{label}\n{input}<i class=\"persent\">%</i>\n{hint}\n{error}",
                    ])->textInput(['style'=>'width:100px']); ?>

                    <?= $form->field($model, 'exchanges_max_count')->textInput(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <br>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <div class="box-title"><?= \Yii::t('app', 'Coins')?></div>
                </div>
                <div class="box-body no-padding limit-height">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach($coins as $i => $coin) : ?>
                            <li<?= $i == 0 ? ' class="active"' : '';?>>
                                <?= Html::a($coin->name, ['formula/coin'],['class' => 'coin_btn', 'rel' => $coin->id]);?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <div class="box-title">Настройки</div>
                </div>
                <div class="box-body no-padding limit-height">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <?= Html::a(\Yii::t('app', 'Mass media'), ['formula/coin'],['class' => 'settings_btn', 'rel' => '1']);?>
                        </li>
                        <li><?= Html::a(\Yii::t('app', 'Community'), ['formula/coin'],['class' => 'settings_btn', 'rel' => '2']);?></li>
                        <li><?= Html::a(\Yii::t('app', 'Developers'), ['formula/coin'],['class' => 'settings_btn', 'rel' => '3']);?></li>
                        <li><?= Html::a(\Yii::t('app', 'Exchanges'), ['formula/coin'],['class' => 'settings_btn', 'rel' => '4']);?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php Pjax::begin(['id' => 'pjax-form','enablePushState' => false]);?>
            <?php
            $percent = $model->news_max_val / 100;
            $result = $percent / ($sites * $model->news_max_count) * $posts['count'];
            ?>
            <pre>Макс. значение параметра / (Кол-во сайтов &times; Макс. кол-во упоминаний для сайта) &times; Кол-во упоминаний всего для монеты<br><br><?= $percent . ' / (' . $sites . ' &times; ' . $model->news_max_count . ') &times; ' . intval($posts['count']) . ' = ' . $result . ' (' . floor($result *100) . '%)';?></pre>

            <?php Pjax::end();?>
        </div>
    </div>
</div>