<?php

namespace core\helpers;


use core\entities\coins\handbook\Handbook;
use core\entities\coins\handbook\HandbookAssignments;
use core\entities\parse\Posts;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * Class DuplicateHelper
 * @package core\helpers
 */
class DuplicateHelper
{
    protected static $exception = [
        '', ' ', 'RT', 'the', 'The', 'of', 'A', 'a', 'To', 'to',
        'Are', 'are', 'On', 'on', 'And', 'and',
        'For', 'for','This', 'this', 'You', 'you',
        'In', 'in', 'An' , 'an', 'Is', 'is',
        'I', 'i', 'Has', 'has', 'With', 'with',
        'Were', 'were', 'My', 'my', 'We', 'we',
        'Hi', 'hi', 'Our', 'our', 'As', 'as', 'More', 'more'
    ];

    /**
     * @param int $coinId
     * @param int $time
     * @return array
     */
    public static function getPosts(int $coinId, int $time): array
    {
        $query = new Query();

        return $query->select('p.id, p.title, p.type, p.text')
                     ->from(Posts::tableName() . ' p')
                     ->leftJoin(HandbookAssignments::tableName() . ' ph', 'ph.post_id = p.id')
                     ->leftJoin(Handbook::tableName() . ' h', 'h.id = ph.handbook_id')
                     ->andWhere(['>', 'p.created', $time - 24 * 60 * 60])
                     ->andFilterWhere(['or', ['p.coin_id' => 0, 'h.coin_id' => $coinId], ['p.coin_id' => $coinId]])
                     ->orderBy(['p.created' => SORT_ASC])
                     ->distinct()
                     ->all();
    }

    public static function returnDuplicates(int $coinId, int $time): array
    {
        $result = [];

        $duplicates = self::getPosts($coinId, $time);

        if(!empty($duplicates)) {
            $titles = $duplicates;

            foreach($duplicates as $key=>$duplicate) {
                $titleArray = explode(' ',trim($duplicate['title']));

                unset($titles[$key]);

                foreach($titles as $tKey=>$title) {
                    $titleInArray = explode(' ',trim($title['title']));

                    $intersect = array_diff(array_unique(array_intersect($titleArray,$titleInArray)), self::$exception);

                    if(count($intersect) >= 3) {
                        $result[$duplicates[$key]['id']]['title'] = $duplicates[$key]['title'];
                        $result[$duplicates[$key]['id']]['type'] = $duplicates[$key]['type'];
                        $result[$duplicates[$key]['id']]['dublicats'][] = [
                            'id' => $duplicates[$tKey]['id'],
                            'title' => $duplicates[$tKey]['title'],
                            'type' => $duplicates[$tKey]['type'],
                        ];

                        unset($titles[$tKey]);
                    }
                }
            }
        }

        return $result;
    }
}