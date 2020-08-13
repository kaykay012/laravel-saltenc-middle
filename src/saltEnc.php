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
        dd('哈哈哈哈啊哈哈啊哈哈');
        return $next($request);
    }
}
