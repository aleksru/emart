<?php

namespace App\Models\Traits;

trait HasBootEvents
{
    /**
     * Register an booting model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function booting($callback)
    {
        static::registerModelEvent('booting', $callback);
    }

    /**
     * Register an booted model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function booted($callback)
    {
        static::registerModelEvent('booted', $callback);
    }

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents()
    {
        return array_merge(
            [
                'booting', 'booted',
                'retrieved', 'creating', 'created', 'updating',
                'updated', 'deleting', 'deleted', 'saving',
                'saved', 'restoring', 'restored',
            ],
            $this->observables
        );
    }
}