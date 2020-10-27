<?php

namespace Rokasma\Esa;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rokasma\Esa\Skeleton\SkeletonClass
 */
class EsaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'esa';
    }
}
