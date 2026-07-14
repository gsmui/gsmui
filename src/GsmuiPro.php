<?php

namespace GsmuiPro;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gsmui\GsmuiManager
 */
class GsmuiPro extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'gsmui-pro';
    }
}
