<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\coins\socials\NetworksForm */

$this->title = Yii::t('app', 'Create Network');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Networks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>