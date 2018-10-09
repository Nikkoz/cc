<?php

namespace core\forms\manage\coins;

use core\entities\User;
use core\forms\manage\coins\socials\SocialsForm;
use core\forms\manage\CompositeForm;
use core\forms\manage\MetaForm;

/**
 * @property string $name
 * @property string $code
 * @property string $alias
 * @property integer $type
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property MetaForm $meta
 * @property PictureForm $picture
 * @property DataForm $data
 * @property LinksForm $links
 * @property ForumForm $forums
 * @property HandbookForm $handbook
 * @property SocialsForm $socials
 */
class CoinsCreateForm extends CompositeForm
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_COIN = 0;
    const TYPE_TOKEN = 1;

    public $name;
    public $code;
    public $alias;
    public $type;
    public $publish;

    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;

    /**
     * CoinsCreateForm constructor.
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->publish = self::STATUS_ACTIVE;
        $this->type = self::TYPE_COIN;

        $this->meta = new MetaForm();
        $this->picture = new PictureForm();
        $this->data = new DataForm();
        $this->links = new LinksForm();
        $this->forums = new ForumForm();
        $this->handbook = new HandbookForm();
        $this->socials = new SocialsForm();

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'code'], 'required'],
            [['created_at', 'updated_at', 'type'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            ['publish', 'default', 'value' => self::STATUS_ACTIVE],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Name'),
            'code' => \Yii::t('app', 'Code'),
            'publish' => \Yii::t('app', 'Publish'),
            'type' => \Yii::t('app', 'Type'),
        ];
    }

    public function getTypes(): array
    {
        return ['Coin', 'Token'];
    }

    protected function internalForms(): array
    {
        return ['picture', 'meta', 'data', 'links', 'forums', 'handbook', 'socials'];
    }
}