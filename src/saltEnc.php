<?php

namespace kaykay012\laravelsaltenc;

use Closure;
use Illuminate\Support\Facades\Storage;

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
        $key_date = env('APP_INVALID_AT');
        $date = $this->decryptStr($key_date, \App\Console\Commands\createInvalidTime::PASSWORD);
        if (!$date)
        {
            return response()->json(['code' => 301, 'message' => '无效的配置：APP_INVALID_AT']);
        }
        $date_str = strtotime($date);
        if (time() > $date_str)
        {
            return response()->json(['code' => 300, 'message' => '已过期']);
        }
        return $next($request);
    }

    /** des解密
     * @param $str
     * @param $key
     * @return mixed
     */
    function decryptStr($str, $key)
    {
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        $res = urldecode(substr($str, 0, strlen($str) - $pad));
        return json_decode(urldecode($res), true);
    }

}
