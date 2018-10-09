<?php

namespace core\forms\manage\coins;

use core\entities\coins\Coins;
use core\entities\User;
use core\forms\manage\coins\socials\SocialsForm;
use core\forms\manage\CompositeForm;
use core\forms\manage\MetaForm;

/**
 * @property integer $id
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
class CoinsEditForm extends CompositeForm
{
    const TYPE_COIN = 0;
    const TYPE_TOKEN = 1;

    public $id;
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
     * CoinsEditForm constructor.
     * @param Coins $coin
     * @param array $config
     */
    public function __construct(Coins $coin, $config = [])
    {
        $this->id = $coin->id;
        $this->name = $coin->name;
        $this->code = $coin->code;
        $this->publish = $coin->publish;
        $this->type = $coin->type;

        $this->meta = new MetaForm($coin->meta);
        $this->picture = new PictureForm($coin);
        $this->data = new DataForm($coin);
        $this->links = new LinksForm($coin);
        $this->forums = new ForumForm($coin->assignmentsForum);
        $this->handbook = new HandbookForm($coin->assignmentsHandbook);
        $this->socials = new SocialsForm($coin->assignmentsSocials);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'code'], 'required'],
            [['created_at', 'updated_at', 'type'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            ['publish', 'default', 'value' => Coins::STATUS_ACTIVE],
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