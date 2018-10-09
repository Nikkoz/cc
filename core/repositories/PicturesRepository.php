<?php

namespace core\repositories;


use core\entities\Pictures;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class PicturesRepository
{
    public function get(int $id): Pictures
    {
        if(!$picture = Pictures::findOne($id)) {
            throw new \DomainException('Pictures is not found.');
        }

        return $picture;
    }

    public function save(Pictures $picture): void
    {
        if(!$picture->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Pictures $picture, string $folder): void
    {
        if(!$picture->delete()) {
            throw new \RuntimeException('Removing error.');
        } else {
            $this->removeFile($picture->name, $folder);
        }
    }

    public function saveFile(UploadedFile $file, string $folder): string
    {
        $dir = \Yii::getAlias('@images') . "/{$folder}/";
        if(!file_exists($dir)) {
            try {
                FileHelper::createDirectory($dir);
            } catch (\yii\base\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }

        if(file_exists($dir . $file->name)) {
            unlink($dir . $file->name);
        }

        $image = time() . '_' . \Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
        $file->saveAs($dir . $image);

        return $image;
    }

    public function removeFile(string $fileName, string $folder): void
    {
        $dir = \Yii::getAlias('@images') . "/{$folder}/";
        if(file_exists($dir . $fileName)) {
            unlink($dir . $fileName);
        }
    }
}