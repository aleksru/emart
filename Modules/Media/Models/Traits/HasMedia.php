<?php

namespace Modules\Media\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Models\Image;

trait HasMedia
{
    /**
     * Возвращает опции медиа модели.
     * 
     * @return mixed
     */
    public function getMedia()
    {
        return $this->media;
    }
    
    /**
     * Возвращает связь многие ко многим для изображений.
     *
     * @param string $type - тип изображения
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function imagesDynamicRelation(string $type = null)
    {
        $builder = $this->morphMany(Image::class, 'morph');
        
        if ($type != null)
            $builder->where('type', $type);
        
        return $builder;
    }

    /**
     * Возвращает связь многие к одному для изображения.
     * 
     * @param string|null $type
     * @return mixed
     */
    public function imageDynamicRelation(string $type = null)
    {
        $builder = $this->morphOne(Image::class, 'morph');
        
        if (!empty($type)) {
            $builder->where('type', $type);
        }

        return $builder;
    }

    /**
     * Eloquent бутит данный метод при создании модели.
     */
    public static function bootHasMedia()
    {
        /**
         * Регистрируем динамические отношения, которые определены в статическом свойстве $media.
         */
        static::booted(function (Model $bootedModel) {
            $media = $bootedModel->getMedia() ?? [];
            foreach ($media as $name => $options) {
                $bootedModel::registerDynamicRelation($name, function ($model, ...$parameters) use ($name, $options) {
                    if ($options['type'] === 'image') {
                        if (!empty($options['single']))
                            return $model->imageDynamicRelation($name);

                        return $model->imagesDynamicRelation($name);
                    }
                });
            }
        });
        
        /**
         * При удалении модели, удалям все связанные с ней изображения.
         */
        static::deleting(function (Model $model) {
            $model->imagesDynamicRelation()->get()->each->delete();
        });
    }
}