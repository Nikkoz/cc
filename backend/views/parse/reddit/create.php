<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\RedditForm */

$this->title = Yii::t('app', 'Create Reddit post');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Parse'), 'url' => ['/posts']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Reddit post'), 'url' => ['/reddit']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
            'is' => 'create'
        ]) ?>
    </div>
</div>