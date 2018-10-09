<?php

namespace core\forms\manage;


use core\entities\Coupons;
use yii\base\Model;

/**
 * Class CouponsForm
 * @package core\forms\manage
 *
 * @property string $code
 * @property int $type
 * @property int $discount
 * @property int $publish
 */
class CouponsForm extends Model
{
    public $code;
    public $type;
    public $discount;
    public $publish;

    public function __construct(Coupons $coupon = null, array $config = [])
    {
        if($coupon) {
            $this->code = $coupon->code;
            $this->type = $coupon->type;
            $this->discount = $coupon->discount;
            $this->publish = $coupon->publish;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['code', 'type', 'discount'], 'required'],
            ['code', 'string', 'max' => 255],
            [['type', 'discount'], 'integer'],
            ['publish', 'boolean']
        ];
    }

    public function getTypes(): array
    {
        return [\Yii::t('app', 'Register'), \Yii::t('app', 'Discount')];
    }
}