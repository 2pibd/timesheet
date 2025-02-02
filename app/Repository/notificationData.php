<?php
namespace App\Repository;

use App\notification;
use Carbon\Carbon;

use Auth;
class notificationData
{
    CONST CACHE_KEY = 'NOTIFICATIONS';
    public function all()
    {
        $uid =Auth::id();
        $cacheKey = "notification.{ $uid }";
        $key = $this->getCacheKey($cacheKey);

        $Result = notification::where('to_id', $uid )->where('status',1)->latest()->skip(0)->take(20)->get();


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
