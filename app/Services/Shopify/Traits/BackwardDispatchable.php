<?php

namespace App\Services\Quidkey\Traits;

use Illuminate\Foundation\Bus\Dispatchable;

trait BackwardDispatchable
{
    use Dispatchable;

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @return mixed
     *
     * @deprecated Will be removed in a future Laravel version.
     */
    public static function dispatchNow(...$arguments): mixed
    {
        return static::dispatchSync(...$arguments);
    }
}
