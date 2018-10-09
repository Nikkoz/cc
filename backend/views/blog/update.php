<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\blog\BlogForm */
/* @var $post \core\entities\Blog */

$this->title = Yii::t('app', 'Update Post');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
            'post' => $post
        ]) ?>
    </div>
</div>