<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    //protected $table = 'currencies';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public static function ConverCurrency($amount, $from_currency, $to_currency)
    {
        $string = $amount . strtolower($from_currency) . "=?" . strtolower($to_currency);
        $google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;
        $result = file_get_contents($google_url);
        $result = explode('"', $result);
        $confrom = explode(' ', $result[1]);
        $conto = explode(' ', $result[3]);
        return $conto[0];
    }

#$converted_value = ConverCurrency(1,"usd","eur");


    public static function currencyConverter($amount, $from, $to, $symbol = false)
    {
        $fromArr = currency::where('code', '=', $from)->get()->first();
        $toArr = currency::where('code', '=', $to)->get()->first();

        $amount = ($amount * $toArr['value']) / $fromArr['value'];

        if ($symbol == true) $amount = $toArr['symbol_left'] . number_format($amount, 2) . $toArr['symbol_right'];

        return $amount;
    }

    public static function toConvert($amount, $from, $to, $rate, $symbol = false)
    {

        $camount = ($amount * $rate);
        $toArr = currency::where('code', '=', $to)->get()->first();
        $amount = $camount / $toArr['value'];

        if ($symbol == true) $amount = $toArr['symbol_left'] . number_format($amount, 2) . $toArr['symbol_right'];

        //if($symbol == true) $amount =$toArr['symbol_left'].number_format($amount,2).$toArr['symbol_right'];

        return $amount;
    }

    public static function setCurrency($amount, $currency)
    {
        $toArr = currency::where('code', '=', $currency)->get()->first();
        return $amount = $toArr['symbol_left'] . number_format($amount, 2) . $toArr['symbol_right'];
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    // protected $fillable = ['title', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'status' ];


}
