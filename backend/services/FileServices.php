<?php

namespace backend;

use finfo;
use yii\web\UploadedFile;

class FileServices
{
    public static function getDataURI($imagePath) {
        $path = \Yii::getAlias('@frontend') . '/web' . $imagePath;
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($path);
        return 'data:' . $type . ';base64,' . base64_encode(file_get_contents($path));
    }

    public static function upload($model): bool
    {
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ( $model->imageFile) {
            if ($model->validate()) {
                $model->photo = '/uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs(\Yii::getAlias('@frontend') . '/web/uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                return true;
            }else {
                return false;
            }
        }
        return true;
    }
}