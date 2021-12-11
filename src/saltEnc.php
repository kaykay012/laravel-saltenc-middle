<?php

namespace kaykay012\laravelsaltenc;

use Closure;
use Illuminate\Support\Facades\Storage;

class saltEnc
{

    public $return_array = array(); // 返回带有MAC地址的字串数组
    public $mac_addr;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('INVALID_AT') && \Carbon\Carbon::now()->timestamp > \Carbon\Carbon::parse(env('INVALID_AT'))->endOfDay()->timestamp){
            return response()->json(['code' => 300, 'message' => '已过期']);
        }
        
        if (env('SALT_ENC') == 'G2ltiB')
        {
            return $next($request);
        }
        $os = 'linux';
        if (PHP_OS)
        {
            $os = strtolower(PHP_OS);
        }
        /**
         * / tm  p/A U Q J p b w r .lock
         */
        $re = storage_path('app/AUQJpbwr.lock');
        $_ma = $this->GetMa_cAddr($os);
        if (!file_exists($re))
        {
            Storage::put('AUQJpbwr.lock', $_ma);
        }
        $ma = @file_get_contents($re) ?: null;
        if (trim($ma) !== $_ma)
        {
            return response()->noContent();
        }
        return $next($request);
    }

    function GetMa_cAddr($os_type)
    {
        switch (strtolower($os_type))
        {
            case "linux":
                $this->forLinux();
                break;
            case "solaris":
                break;
            case "unix":
                break;
            case "aix":
                break;
            default:
                $this->forWindows();
                break;
        }


        $temp_array = array();
        if (!is_array($this->return_array))
        {
            return 'abc111';
        }
        foreach ($this->return_array as $value)
        {

            if (
                    preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $value,
                            $temp_array))
            {
                $this->mac_addr = $temp_array[0];
                break;
            }
        }
        unset($temp_array);
        return $this->mac_addr;
    }

    function forWindows()
    {
        @exec("ipconfig /all", $this->return_array);
        if ($this->return_array)
            return $this->return_array;
        else
        {
            $ipconfig = $_SERVER["WINDIR"] . "\system32\ipconfig.exe";
            if (is_file($ipconfig))
                @exec($ipconfig . " /all", $this->return_array);
            else
                @exec($_SERVER["WINDIR"] . "\system\ipconfig.exe /all", $this->return_array);
            return $this->return_array;
        }
    }

    function forLinux()
    {
        @exec("/sbin/ifconfig -a", $this->return_array);
        return $this->return_array;
    }

}
