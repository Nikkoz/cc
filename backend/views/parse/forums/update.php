<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\ForumsForm */

$this->title = Yii::t('app', 'Update Forums message');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Parse'), 'url' => ['/posts']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Forums messages'), 'url' => ['/forums']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
            'is' => 'update'
        ]) ?>
    </div>
</div>