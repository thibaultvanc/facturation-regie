<?php

namespace FacturationRegie;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thibaultvanc\FacturationRegie\Skeleton\SkeletonClass
 */
class FacturationRegieFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'facturation-regie';
    }
}
