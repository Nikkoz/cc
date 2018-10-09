<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\SeoForm */

$this->title = Yii::t('app', 'Update Seo');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Seo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>