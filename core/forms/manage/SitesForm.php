<?php

namespace core\forms\manage;


use core\entities\Sites;
use yii\base\Model;

/**
 * Class SitesForm
 * @package core\forms\manage
 *
 * @property string $name
 * @property string $link
 * @property integer $publish
 */
class SitesForm extends Model
{
    public $name;
    public $link;
    public $publish;

    public function __construct(Sites $site = null, array $config = [])
    {
        if($site) {
            $this->name = $site->name;
            $this->link = $site->link;
            $this->publish = $site->publish;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'link'], 'required'],
            [['name', 'link'], 'string', 'max' => 255],
            ['publish', 'integer']
        ];
    }
}