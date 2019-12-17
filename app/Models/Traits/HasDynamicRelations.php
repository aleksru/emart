<?php

namespace App\Models\Traits;

/**
 * Позволяет динамически подгружать отношения для моделей.
 * 
 * @package App\Models\Traits
 */
trait HasDynamicRelations
{
    /**
     * Сюда регистрируются динамические отношения
     * 
     * @var array
     */
    public static $dynamicRelations = [];

    /**
     * Регистрирует динамическое отношение
     * 
     * @param $method
     * @param \Closure $closure
     */
    public static function registerDynamicRelation($method, \Closure $closure)
    {
        array_set(static::$dynamicRelations, static::class. '.' . $method, $closure);
    }

    /**
     * Отчищает динамическое отношение
     * 
     * @param $method
     */
    public static function clearDynamicRelation($method)
    {
        if (array_has(static::$dynamicRelations, static::class. '.' . $method))
            unset(static::$dynamicRelations[static::class][$method]);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        /**
         * Проверяем наличие отношение в массиве динамических отношений.
         */
        if ($relationMethod = array_get(static::$dynamicRelations, static::class . '.' . $method)) {
            return $relationMethod($this, ...$parameters);
        }

        return $this->newQuery()->$method(...$parameters);
    }

    /**
     * Get a relationship.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        // Дополняем этот метод еще одной проверкой в массиве динамических отношений.
        if (method_exists($this, $key) || array_has(static::$dynamicRelations, static::class. '.' . $key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }
}