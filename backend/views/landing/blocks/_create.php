<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\landing\Blocks\ElementTwoForm */
/* @var $block_id integer */

$this->title = \Yii::t('app', 'Creating');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Blocks'), 'url' => ['/landing/blocks']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?php echo $this->render('_elementForm', [
            'model' => $model,
            'block_id' => $block_id,
            'create' => true
        ]);?>
    </div>
</div>