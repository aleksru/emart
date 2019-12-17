<?php
/**
 * Created by PhpStorm.
 * User: jes490
 * Date: 06.02.2019
 * Time: 8:51
 */

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Model;

trait HasHash
{
    /**
     * Возвращает атрибуты, на основе которых 
     * нужно строить хеш.
     * 
     * @return array
     */
    protected function getHashable()
    {
        return $this->hashable ?? [];
    }

    /**
     * Возвращает название столбца, в котором 
     * хранить хеш.
     * 
     * @return string
     */
    protected function getHashColumn()
    {
        return $this->hashColumn ?? 'hash';
    }

    /**
     * Подключает трейт.
     */
    public static function bootHasHash()
    {
        /**
         * Строим хеш на основе конкатенации хешируемых
         * столбцов. 
         */
        static::saving(function (Model $model) {
            $hashString = '';
            foreach ($model->getHashable() as $column) {
                $hashString .= (string) $model[$column];
            }
            $hashColumn = $model->getHashColumn();
            $model[$hashColumn] = md5($hashString);
        });
    }

}