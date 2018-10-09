<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.08.2018
 * Time: 14:46
 */

namespace core\forms\manage\coins\socials;


use core\entities\coins\socials\Networks;
use yii\base\Model;

/**
 * Class NetworkForm
 * @package core\forms\manage\coins\socials
 *
 * @property string $name
 * @property string $link
 * @property integer $publish
 */
class NetworksForm extends Model
{
    public $name;
    public $link;
    public $publish;

    public function __construct(Networks $network = null, array $config = [])
    {
        if ($network) {
            $this->name = $network->name;
            $this->link = $network->link;
            $this->publish = $network->publish;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'link'], 'required'],
            [['name', 'link'], 'string', 'max' => 255],
            ['publish', 'boolean'],
        ];
    }
}