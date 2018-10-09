<?php

namespace core\services\manage\landing;

use core\entities\landing\Elements;
use core\entities\Pictures;
use core\forms\manage\landing\Blocks\ElementFourForm;
use core\forms\manage\landing\Blocks\ElementSixForm;
use core\forms\manage\landing\Blocks\ElementThreeForm;
use core\forms\manage\landing\Blocks\ElementTwoForm;
use core\repositories\landing\ElementRepository;
use core\repositories\PicturesRepository;
use core\services\TransactionManager;

/**
 * Class ElementsManageService
 * @package core\services\manage\landing
 *
 * @property ElementRepository $repository
 * @property PicturesRepository $pictureRepository
 * @property TransactionManager $transaction
 */
class ElementsManageService
{
    private $repository;
    private $transaction;

    public function __construct(
        ElementRepository $repository,
        TransactionManager $transaction,
        PicturesRepository $pictureRepository
    )
    {
        $this->repository = $repository;
        $this->transaction = $transaction;
        $this->pictureRepository = $pictureRepository;
    }

    /**
     * @param ElementTwoForm | ElementThreeForm | ElementFourForm | ElementSixForm $form
     * @return Elements
     */
    public function create($form): Elements
    {
        $element = Elements::create($form->block_id, $form->text, $form->preview ?: '');

        $this->transaction->wrap(function () use ($element, $form) {
            if (isset($form->picture) && $form->picture->file) {
                $file = $this->pictureRepository->saveFile($form->picture->file, 'landing');

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $element->assignPicture($picture->id);
            }

            $this->repository->save($element);
        });

        return $element;
    }

    /**
     * @param int $id
     * @param ElementTwoForm | ElementThreeForm | ElementFourForm | ElementSixForm $form
     */
    public function edit(int $id, $form): void
    {
        $element = $this->repository->get($id);

        $element->edit($form->block_id, $form->text, $form->preview ?: '');

        $this->transaction->wrap(function () use ($element, $form) {
            if (isset($form->picture) && $form->picture->file) {
                $file = $this->pictureRepository->saveFile($form->picture->file, 'landing');

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                if($element->image) {
                    $this->checkPicture($picture->id, $element->image);
                }

                $element->assignPicture($picture->id);
            }

            $this->repository->save($element);
        });
    }

    public function remove(int $id): void
    {
        $element = $this->repository->get($id);

        if($element->image) {
            $picture = $this->pictureRepository->get($element->image);
            $this->pictureRepository->remove($picture, 'landing');
        }

        $this->repository->remove($element);
    }

    public function getBlock(int $id): int
    {
        $element = $this->repository->get($id);

        return $element->block_id;
    }

    public function removePicture(int $id): void
    {
        $element = $this->repository->get($id);
        $picture = $this->pictureRepository->get($element->image);

        $element->revokePicture();
        $this->repository->save($element);
        $this->pictureRepository->remove($picture, 'landing');
    }

    private function checkPicture(int $newId, int $id = null): void
    {
        if ($id && $id != $newId) {
            $picture = $this->pictureRepository->get($id);
            $this->pictureRepository->remove($picture, 'landing');
        }
    }
}