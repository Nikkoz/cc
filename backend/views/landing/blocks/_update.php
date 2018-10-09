<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\landing\Blocks\ElementTwoForm */
/* @var $element \core\entities\landing\Elements*/
/* @var $block_id integer */

$this->title = \Yii::t('app', 'Updating');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Blocks'), 'url' => ['/landing/blocks']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?php echo $this->render('_elementForm', [
            'model' => $model,
            'block_id' => $element->block_id,
            'element' => $element,
            'create' => false
        ]);?>
    </div>
</div>