<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\algorithm\ConsensusForm */

use yii\helpers\Url;

$this->title = Yii::t('app', 'Update Algorithm consensus');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Algorithm consensus'), 'url' => Url::toRoute(['/consensus'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>