<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ExchangesForm */

$this->title = Yii::t('app', 'Create Exchange');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Exchanges'), 'url' => ['/exchanges']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>