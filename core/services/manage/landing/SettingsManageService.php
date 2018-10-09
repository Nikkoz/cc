<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.08.2018
 * Time: 14:47
 */

namespace core\services\manage\landing;


use core\forms\manage\landing\SettingsForm;
use core\repositories\landing\SettingsRepository;

/**
 * Class SettingsManageService
 * @package core\services\manage\landing
 *
 * @property SettingsRepository $repository
 */
class SettingsManageService
{
    private $repository;

    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function edit(int $id, SettingsForm $form): void
    {
        $settings = $this->repository->get($id);

        $settings->edit($form->email, $form->donate);

        $this->repository->save($settings);
    }
}