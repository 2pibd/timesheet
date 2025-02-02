<?php
namespace App\Repository;

use App\basic;
use Carbon\Carbon;
use Auth;
class geoLocation
{
    CONST CACHE_KEY = 'geoLocation';


    public function geoIP()
    {
        $cacheKey = "geoLocation";
        $key = $this->getCacheKey($cacheKey);


        $array = array();
        $clientIp = basic::getUserIP();


        $Result = unserialize(@file_get_contents('http://www.geoplugin.net/php.gp?ip=' .  $clientIp));

        return  cache()->remember($cacheKey, Carbon::now()->addMinutes(20), function () use($Result){
            return $Result;
        });


    }



    public function getCacheKey($key){
        $key = strtoupper($key);
        return self::CACHE_KEY .".$key";
    }
}
?>
