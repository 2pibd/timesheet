<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company_address extends Model
{
    //
    protected $table = 'company_addresses';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'address_type', 'address1', 'address2','address3','address4','address5','address6','address7','address8','address9','address10'
        , 'city', 'state', 'postcode', 'country', 'is_default' ];


    public function CountryLoad(){
        return $this->belongsTo('App\Models\country', 'country', 'country_id');
    }

    public function StateLoad(){
        return $this->belongsTo('App\Models\state', 'state', 'state_id');
    }

    public function CityLoad(){
        return $this->belongsTo('App\Models\city', 'city', 'city_id');
    }


    public function company(){
        return $this->belongsTo('App\Models\company_contact_info',  'company_id');
    }



}
