<?php

namespace core\services\manage;


use core\entities\Coupons;
use core\forms\manage\CouponsForm;
use core\repositories\CouponsRepository;

/**
 * Class CouponManageService
 * @package core\services\manage
 *
 * @property CouponsRepository $repository
 */
class CouponManageService
{
    private $repository;

    public function __construct(CouponsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CouponsForm $form): Coupons
    {
        $coupon = Coupons::create($form->code, $form->type, $form->discount, $form->publish);

        $this->repository->save($coupon);

        return $coupon;
    }

    public function edit(int $id, CouponsForm $form): void
    {
        $coupon = $this->repository->get($id);

        $coupon->edit($form->code, $form->type, $form->discount, $form->publish);

        $this->repository->save($coupon);
    }

    public function remove(int $id): void
    {
        $coupon = $this->repository->get($id);
        $this->repository->remove($coupon);
    }

    public function activate(int $id): void
    {
        $site = $this->repository->get($id);
        $site->activate();
        $this->repository->save($site);
    }

    public function deactivate(int $id): void
    {
        $site = $this->repository->get($id);
        $site->deactivate();
        $this->repository->save($site);
    }
}