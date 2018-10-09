<?php

namespace core\forms\manage\posts;


use core\entities\coins\handbook\Handbook;
use core\entities\parse\Posts;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class HandbookForm
 * @package core\forms\manage\posts
 *
 * @property array $handbook
 */
class HandbookForm extends Model
{
    public $handbook;

    public function __construct(Posts $post = null, array $config = [])
    {
        if($post) {
            $this->handbook = ArrayHelper::getColumn($post->handbookAssignments, 'handbook_id');
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['handbook', 'required'],
            ['handbook', 'each', 'rule' => ['integer']]
        ];
    }

    public function handbookList(): array
    {
        return ArrayHelper::map(Handbook::find()->active()->asArray()->all(), 'id', 'title');
    }

    public function beforeValidate(): bool
    {
        $this->handbook = array_filter((array)$this->handbook);
        return parent::beforeValidate();
    }
}