<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\SitesForm */

$this->title = Yii::t('app', 'Create Site');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>