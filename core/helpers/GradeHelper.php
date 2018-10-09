<?php

namespace core\helpers;


class GradeHelper
{
    public static function returnFilterVote(): array
    {
        return [
            \Yii::t('app', 'Like'),
            \Yii::t('app', 'Dislike'),
            \Yii::t('app', 'Growth up'),
            \Yii::t('app', 'Growth down'),
            \Yii::t('app', 'Important'),
            \Yii::t('app', 'Unimportant'),
            \Yii::t('app', 'Toxic'),
            \Yii::t('app', 'Saved'),
        ];
    }

    public static function returnGrade(string $type, string $val): ?string
    {
        switch ($type) {
            case 'like': return $val == 'Y' ? \Yii::t('app', 'Like') : \Yii::t('app', 'Dislike'); break;
            case 'growth': return $val == 'Y' ? \Yii::t('app', 'Growth up') : \Yii::t('app', 'Growth down'); break;
            case 'important': return $val == 'Y' ? \Yii::t('app', 'Important') : \Yii::t('app', 'Unimportant'); break;
            case 'toxic': return $val == 'Y' ? \Yii::t('app', 'Toxic') : \Yii::t('app', 'Not toxic'); break;
            case 'save': return $val == 'Y' ? \Yii::t('app', 'Saved') : null; break;
        }
    }
}