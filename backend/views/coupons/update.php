<?php

/* @var $this yii\web\View */
/* @var \core\forms\manage\CouponsForm */

$this->title = Yii::t('app', 'Update Coupon');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Coupons'), 'url' => ['/coupons']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>