<?php

namespace core\services\manage\coins;

use core\entities\coins\Forums;
use core\entities\coins\handbook\Handbook;
use core\entities\coins\socials\Socials;
use core\entities\Meta;
use core\entities\Pictures;
use core\entities\coins\Coins;
use core\forms\manage\coins\CoinsCreateForm;
use core\forms\manage\coins\CoinsEditForm;
use core\repositories\coins\CoinsRepository;
use core\repositories\coins\ForumsRepository;
use core\repositories\coins\HandbookRepository;
use core\repositories\coins\socials\SocialsRepository;
use core\services\TransactionManager;
use core\repositories\PicturesRepository;
use yii\helpers\ArrayHelper;

/**
 * Class CoinsManageService
 * @package core\services\manage\coins
 *
 * @property CoinsRepository $repository
 * @property PicturesRepository $picturesRepository
 * @property HandbookRepository $handbookRepository
 * @property ForumsRepository $forumsRepository
 * @property SocialsRepository $socialsRepository
 * @property TransactionManager $transaction
 */
class CoinsManageService
{
    private $repository;
    private $picturesRepository;
    private $handbookRepository;
    private $forumsRepository;
    private $socialsRepository;
    private $transaction;

    public function __construct(
        CoinsRepository $repository,
        TransactionManager $transaction,
        PicturesRepository $picturesRepository,
        HandbookRepository $handbookRepository,
        SocialsRepository $socialsRepository,
        ForumsRepository $forumsRepository
    )
    {
        $this->repository = $repository;
        $this->picturesRepository = $picturesRepository;
        $this->handbookRepository = $handbookRepository;
        $this->forumsRepository = $forumsRepository;
        $this->socialsRepository = $socialsRepository;
        $this->transaction = $transaction;
    }

    public function create(CoinsCreateForm $form): Coins
    {
        $coin = Coins::create(
            $form->name,
            $form->code,
            $form->publish,
            $form->type,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if (!empty($form->data)) {
            $coin->setData($form->data);
        }

        if (!empty($form->links)) {
            $coin->setLinks($form->links);
        }

        $this->transaction->wrap(function () use ($coin, $form) {
            if ($form->picture->file) {
                $file = $this->picturesRepository->saveFile($form->picture->file, 'coins');

                $picture = Pictures::create($file);
                $this->picturesRepository->save($picture);

                $coin->assignPicture($picture->id);
            }

            $this->repository->save($coin);
        });

        foreach ($form->forums->schedule as $item) {
            if (!empty($item['link']) && !empty($item['admin'])) {
                $forum = Forums::create($item['link'], $item['admin']);
                $forum->assignCoin($coin->id);

                $this->forumsRepository->save($forum);
            }
        }

        foreach ($form->handbook->words as $hb) {
            if (!empty($hb['title'])) {
                $handbook = Handbook::create($hb['title'], $hb['publish'], $hb['check_case']);
                $handbook->assignCoin($coin->id);

                $this->handbookRepository->save($handbook);
            }
        }

        foreach ($form->socials->social as $social) {
            if(!empty($social['link'])) {
                $social = Socials::create($social['link'], $social['type'], $social['description']);
                $social->assignCoin($coin->id);

                $this->socialsRepository->save($social);
            }
        }

        return $coin;
    }

    public function edit(int $id, CoinsEditForm $form): void
    {
        $coin = $this->repository->get($id);

        $coin->edit(
            $form->name,
            $form->code,
            $form->publish,
            $form->type,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if (!empty($form->data)) {
            $coin->setData($form->data);
        }

        if (!empty($form->links)) {
            $coin->setLinks($form->links);
        }

        $this->transaction->wrap(function () use ($coin, $form) {
            if ($form->picture->file) {
                $file = $this->picturesRepository->saveFile($form->picture->file, 'coins');

                $picture = Pictures::create($file);
                $this->picturesRepository->save($picture);

                $this->checkPicture($picture->id, $coin->image);

                $coin->assignPicture($picture->id);
            }

            $this->repository->save($coin);
        });

        $assignmentsForum = ArrayHelper::getColumn($coin->assignmentsForum, 'id');
        $newAssignmentsForum = [];

        foreach ($form->forums->schedule as $item) {
            if (!empty($item['link']) && !empty($item['admin'])) {
                if ($item['id']) {
                    $forum = $this->forumsRepository->get($item['id']);
                    $forum->edit($item['link'], $item['admin']);
                } else {
                    $forum = Forums::create($item['link'], $item['admin']);
                }

                $forum->assignCoin($coin->id);

                $this->forumsRepository->save($forum);

                $newAssignmentsForum[] = $forum->id;
            }
        }

        $assignmentsHandbook = ArrayHelper::getColumn($coin->assignmentsHandbook, 'id');
        $newAssignmentsHandbook = [];

        foreach ($form->handbook->words as $hb) {
            if (!empty($hb['title'])) {
                if ($hb['id']) {
                    $handbook = $this->handbookRepository->get($hb['id']);
                    $handbook->edit($hb['title'], $hb['publish'], $hb['check_case']);
                } else {
                    $handbook = Handbook::create($hb['title'], $hb['publish'], $hb['check_case']);
                }

                $handbook->assignCoin($coin->id);

                $this->handbookRepository->save($handbook);

                $newAssignmentsHandbook[] = $handbook->id;
            }
        }

        $assignmentsSocial = ArrayHelper::getColumn($coin->assignmentsSocials, 'id');
        $newAssignmentsSocial = [];

        foreach ($form->socials->social as $s) {
            if (!empty($s['link'])) {
                if ($s['id']) {
                    $social = $this->socialsRepository->get($s['id']);
                    $social->edit($s['link'], $s['type'], $s['description']);
                } else {
                    $social = Socials::create($s['link'], $s['type'], $s['description']);
                }

                $social->assignCoin($coin->id);

                $this->socialsRepository->save($social);

                $newAssignmentsSocial[] = $social->id;
            }
        }

        $this->removeForum(\array_diff($assignmentsForum, $newAssignmentsForum));
        $this->removeHandbook(\array_diff($assignmentsHandbook, $newAssignmentsHandbook));
        $this->removeSocials(\array_diff($assignmentsSocial, $newAssignmentsSocial));
    }

    public function remove($id): void
    {
        $coin = $this->repository->get($id);

        if($coin->image) {
            $picture = $this->picturesRepository->get($coin->image);
            $this->picturesRepository->remove($picture, 'coins');
        }

        $this->repository->remove($coin);

    }

    public function removePicture(int $id): void
    {
        $coin = $this->repository->get($id);
        $picture = $this->picturesRepository->get($coin->image);

        $coin->revokePicture();
        $this->picturesRepository->remove($picture, 'coins');
    }

    /**
     * Removing forums if them was deleted
     * @param array $forums - list of id
     */
    private function removeForum(array $forums): void
    {
        foreach ($forums as $forumId) {
            $forum = $this->forumsRepository->get($forumId);
            $this->forumsRepository->remove($forum);
        }
    }

    /**
     * Removing handbooks if them was deleted
     * @param array $handbooks - list of id
     */
    private function removeHandbook(array $handbooks): void
    {
        foreach ($handbooks as $handbookId) {
            $handbook = $this->handbookRepository->get($handbookId);
            $this->handbookRepository->remove($handbook);
        }
    }

    /**
     * Removing socials if them was deleted
     * @param array $socials - list of id
     */
    private function removeSocials(array $socials): void
    {
        foreach ($socials as $socialId) {
            $social = $this->socialsRepository->get($socialId);
            $this->socialsRepository->remove($social);
        }
    }

    private function checkPicture(int $newId, int $id = null): void
    {
        if ($id && $id != $newId) {
            $picture = $this->picturesRepository->get($id);
            $this->picturesRepository->remove($picture, 'coins');
        }
    }

    public function activate(int $id): void
    {
        $coin = $this->repository->get($id);
        $coin->activate();
        $this->repository->save($coin);
    }

    public function deactivate(int $id): void
    {
        $coin = $this->repository->get($id);
        $coin->deactivate();
        $this->repository->save($coin);
    }

    /*public function getForums(int $coinId): array
    {
        try {
            return $this->forumsRepository->getBy(['coin_id' => $coinId]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
        }

        return [];
    }

    public function getHandbook(int $coinId): array
    {
        try {
            return $this->handbookRepository->getBy(['coin_id' => $coinId]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
        }

        return [];
    }*/
}