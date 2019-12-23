<?php

namespace Modules\Seo\Models\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Seo\Models\Seo;

trait HasSeo
{
    /**
     * Полиморфная связь один-к-одному для SEO.
     * 
     * @return MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'morph');
    }

    /**
     * Регистрируем SEO.
     */
    public static function bootHasSeo()
    {
        /**
         * Проверяет, есть ли какие-то данные для создания/изменения seo.
         * 
         * @param $data
         * @return bool
         */
        $isEmpty = function ($data) {
            return empty($data['header']) && empty($data['header_2']) && empty($data['title']) && empty($data['keywords'])
                && empty($data['description'] && empty($data['content']));
        };
        
        /**
         * При сохранении модели, проверяем атрибут SEO и сохраняем из него все данные.
         */
        static::saving(function (Model $model) use ($isEmpty) {
            $attributes = $model->getAttributes();
            if (!empty($attributes['seo']) && is_array($attributes['seo'])) {
                $seo = $attributes['seo'];
                // Убираем вспомогательное свойство, поскольку его нет в базовой таблице модели.
                unset($model['seo']);
                if ($model->seo) {
                    if ($isEmpty($seo))
                        $model->seo->delete();
                    else
                        $model->seo->update($seo);
                }
                else {
                    if (!$isEmpty($seo))
                        $model->seo()->save(Seo::make($seo));
                }
            } 
        });
        
        /**
         * При удалении модели, удалям все связанные с ней SEO записи.
         */
        static::deleting(function (Model $model) {
            $model->seo()->delete();
        });
    }
}