<?php

namespace Modules\Media\Observers;

use Illuminate\Support\Facades\DB;
use Modules\Media\Models\Image;

/**
 * Class ImageObserver
 * @package Modules\Images\Observers
 */
class ImageObserver
{
    /**
     * Удалим связанное изображение или папку при удалении модели
     * 
     * @param Image $image
     */
    public function deleting(Image $image)
    {
        $this->deleteFiles($image);
        $image->children()->get()->each->delete();
    }

    /**
     * Удалим все связанные с моделью файлы
     * 
     * @param Image $image
     */
    private function deleteFiles(Image $image)
    {
        $fullPath = public_path($image->path);
        if (is_null($image->parent_id)) {
            $imagePath = pathinfo($fullPath, PATHINFO_DIRNAME);
            array_map(
                function ($file) {
                    unlink($file);
                },
                glob($imagePath . DIRECTORY_SEPARATOR . '*')
            );
            rmdir($imagePath);
        } else {
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }
}