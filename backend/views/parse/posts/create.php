<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\PostsForm */

$this->title = Yii::t('app', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>