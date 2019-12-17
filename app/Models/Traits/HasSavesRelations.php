<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Trait HasSavesRelations
 * Автоматическое сохранение всех отношений для модели.
 * 
 * @package App\Models\Traits
 */
trait HasSavesRelations
{
    /**
     * Возвращает отношения, которые следует автоматически сохранять.
     * 
     * @return array
     */
    public function getSavesRelations()
    {
        return $this->savesRelations ?? [];
    }

    /**
     * Подключает трейт.
     */
    public static function bootHasSavesRelations()
    {
        /**
         * Для удобства использования, можно держать данные для отношений
         * в атрибутах модели. На событии сохранения мы вытаскиваем их из 
         * атрибутов и проставляем в отношения, для предотвращения ошибок записи
         * в базу из-за несуществующих атрибутов. 
         */
        static::saving(function (Model $model) {
            foreach ($model->getSavesRelations() as $relations) {
                $model->setRelationsFromAttributes($model, (array) $relations);
            } 
        });

        /**
         * Автоматически сохраняем все данные отношений.
         * Сохраняем только те данные, которые являются обычным массивом.
         * Если это Eloquent коллекция, тогда мы ничего не трогаем.
         */
        static::saved(function (Model $model) {
            foreach ($model->getSavesRelations() as $type => $relations) {
                $model->saveRelations($model, (array) $relations, $type);
            }
        });
    }

    /**
     * Устанавливает данные из атрибутов в отношения для 
     * последующего сохранения.
     * 
     * @param Model $model
     * @param array $relations
     */
    protected function setRelationsFromAttributes(Model $model, array $relations)
    {
        foreach ($relations as $relation) {
            // Вытаскиваем данные из атрибутов
            // Данные могут быть как массивом, так и обычной коллекцией (только не Eloquent)
            $value = $model->getAttributeValue($relation);
            $value = $value instanceof Collection ? $value->toArray() : $value;
            // Убираем данные из атрибутов для предотвращения ошибок
            unset($model[$relation]);
            // Если значение не пустое, тогда устанавливаем его в данные отношений.
            // Впоследствии эти данные будут использоваться в событии saved.
            if (!is_null($value)) {
                $model->setRelation($relation, $value);
            }
        }
    }

    /**
     * Сохраняет выбранные отношения.
     * 
     * @param Model $model
     * @param array $relations
     * @param $type
     */
    protected function saveRelations(Model $model, array $relations, $type)
    {
        foreach ($relations as $relation) {
            // Получаем данные из отношений, если они там есть.
            if ($model->relationLoaded($relation)) {
                $data = $model->getRelation($relation);
                // Если данные в отношениях есть, то сохраняем их и 
                // устанавливаем новые записанные данные в виде коллекции
                if (is_array($data)) {
                    switch (mb_strtoLower($type)) {
                        case 'many-to-many':
                            $this->saveManyToManyRelation($model, $relation, $data);
                            break;
                        case 'has-many':
                            $this->saveHasManyRelation($model, $relation, $data);
                            break;
                        case 'has-one':
                            $this->saveHasOneRelation($model, $relation, $data);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
    }

    /**
     * Сохраняет и устанавливает ManyToMany отношения.
     * 
     * @param Model $model
     * @param string $relation
     * @param array $data
     */
    protected function saveManyToManyRelation(Model $model, string $relation, array $data)
    {
        $synced = $model->$relation()->sync(collect($data)->pluck('id'));
        $model->setRelation($relation, $synced['updated']);
    }

    /**
     * Сохраняет и устанавливает HasMany отношения.
     * 
     * @param Model $model
     * @param string $relation
     * @param array $data
     */
    protected function saveHasManyRelation(Model $model, string $relation, array $data)
    {
        $model->$relation()->delete();
        $model->setRelation($relation, $model->$relation()->createMany($data));
    }

    /**
     * Сохраняет и устанавливает HasOne отношения.
     * 
     * @param Model $model
     * @param string $relation
     * @param array $data
     */
    protected function saveHasOneRelation(Model $model, string $relation, array $data)
    {
        $model->$relation()->delete();
        $model->setRelation($relation, $model->$relation()->create($data));
    }
}