<?php

namespace Rmsramos\ChangeUser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rmsramos\ChangeUser\ChangeUser
 */
class ChangeUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rmsramos\ChangeUser\ChangeUser::class;
    }
}
