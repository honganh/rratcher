<?php namespace Ravenuzz\Notify;

use Illuminate\Support\Facades\Facade;

class NotifyFacade extends Facade {

    /**
     * Facade Accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ravenuzz-notify';
    }
}
