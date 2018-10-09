<?php
use yii\widgets\Pjax;

/* @var $formula \core\entities\Formula */
/* @var $sites \core\entities\Sites */

Pjax::begin(['id' => 'pjax-form','enablePushState' => false]);

if($type == 1) :
    $persent = $formula->news_max_val / 100;
    $result = $persent / ($sites * $formula->news_max_count) * $count;
    ?>

    <pre>Макс. значение параметра / (Кол-во сайтов &times; Макс. кол-во упоминаний для сайта) &times; Кол-во упоминаний всего для монеты<br><br><?= $persent . ' / (' . $sites . ' &times; ' . $formula->news_max_count . ') &times; ' . intval($count) . ' = ' . $result . ' (' . floor($result *100) . '%)';?></pre>
<?php
elseif($type == 2) :
    $persent = $formula->community_max_val / 100;
    $result = $persent / $formula->community_max_count * $count;
    ?>

    <pre>Макс. значение параметра / Макс. кол-во единиц &times; Кол-во активностей для монеты<br><br><?= $persent . ' / ' . $formula->community_max_count . ' &times; ' . intval($count) . ' = ' . $result . ' (' . floor($result *100) . '%)';?></pre>

<?php
elseif($type == 3) :
    $persent = $formula->developers_max_val / 100;
    $result = $persent / (4 * $formula->developers_max_count) * $count;
    ?>

    <pre>Макс. значение параметра / (Кол-во каналов &times; Кол-во событий) &times; Кол-во активностей для монеты<br><br><?= $persent . ' / (4 &times; ' . $formula->developers_max_count . ') &times; ' . intval($count) . ' = ' . $result . ' (' . floor($result *100) . '%)';?></pre>

<?php
elseif($type == 4) :
    $persent = $formula->exchanges_max_val / 100;
    $result = $persent / (3 * $formula->exchanges_max_count) * $count;
    ?>

    <pre>Макс. значение параметра / (Кол-во бирж &times; Кол-во событий) &times; Кол-во упоминаний для монеты<br><br><?= $persent . ' / (3 &times; ' . $formula->developers_max_count . ') &times; ' . intval($count) . ' = ' . $result . ' (' . floor($result *100) . '%)';?></pre>

<?php
endif;
Pjax::end();?>