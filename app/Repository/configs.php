<?php
namespace App\Repository;

use App\Helpers\Helper;
use App\Models\job_type;
use Carbon\Carbon;
use Auth;
class configs
{
    CONST CACHE_KEY = 'CONFIGS';


    public function ConfigStatusList()
    {
        $cacheKey = "status_list";

        $key = $this->getCacheKey($cacheKey);
        $Result=Helper::statusList();

        return  cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function () use($Result){
            return $Result;
        });


    }
    public function ConfigJobType(){
        $cacheKey = "job_type";
        $key = $this->getCacheKey($cacheKey);


        $Result =  job_type::all();
        return  cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function () use($Result){
            return $Result;
        });

    }


    public function getCacheKey($key){
        $key = strtoupper($key);
        return self::CACHE_KEY .".$key";
    }
}
?>
