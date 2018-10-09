<?php

namespace core\repositories;


use core\entities\Coupons;

class CouponsRepository
{
    public function get(int $id): Coupons
    {
        if(!$coupon = Coupons::findOne($id)) {
            throw new \DomainException('Coupon is not found.');
        }

        return $coupon;
    }

    public function save(Coupons $coupon): void
    {
        if(!$coupon->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Coupons $coupon): void
    {
        if(!$coupon->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}