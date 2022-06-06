<?php

namespace Chapa\ChapaLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chapa\ChapaLaravel\Skeleton\SkeletonClass
 */
class ChapaLaravelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chapa-laravel';
    }
}
