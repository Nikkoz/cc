<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\manage\DuplicateSearch */

$this->title = \Yii::t('app', 'Duplicates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table__scroll">
                <table id="table_dublicats" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Монета</th>
                        <th>Нижнее значение индекса (Дата)</th>
                        <th>Текущее значение(Процент роста)</th>
                        <th>Время фиксации роста</th>
                        <th>Стоимость монеты(USD)</th>
                        <th>Заголовок первоисточника</th>
                        <th>Дубликаты</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach($model as $coin) :
                        foreach($coin->duplicate as $id=>$duplicate) : ?>
                            <tr>
                                <td><?= ++$i;?></td>
                                <td>
                                    <?= Html::a($coin->coin->name, ['coins/update', 'id' => $coin->coin->id]);?>
                                </td>
                                <td>
                                    <b><?= $coin->index_down?>%</b> (<?= date('d.m.Y H:i', $coin->time_down);?>)
                                </td>
                                <td>
                                    <b><?= $coin->index_up;?>%</b> (<?= round(($coin->index_up - $coin->index_down) / $coin->index_down * 100,1)?>%)
                                </td>
                                <td>
                                    <?= date('d.m.Y H:i', $coin->time_up);?>
                                </td>
                                <td>
                                    <?= $coin->price;?>
                                </td>
                                <td>
                                    <?= Html::a($duplicate['title'], ["{$duplicate['type']}/update", 'id' => $id]);?>
                                </td>
                                <td>
                                    <?= Html::a(count($duplicate['dublicats']), ['follow-coins/list', 'id' => $coin->id, 'post' => $id]);?>
                                </td>
                            </tr>
                        <?php endforeach;
                    endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>