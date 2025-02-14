<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client_contact_info extends Model
{
    //
    protected $table = 'client_contact_infos';

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
    protected $fillable = ['company_id', 'address_id','name_title','first_name','middle_name','last_name','contact_name',
        'contact_designation', 'contact_phone1', 'contact_phone2', 'contact_email',  'is_default','business_card' ];

    public function  emails(){
        return $this->hasMany('App\company_contact_email' , 'company_contact_id'   );
    }

    public function  phones(){
        return $this->hasMany('App\company_contact_info_phone' , 'company_contact_info_id'   );
    }

    public function  company(){
        return $this->belongsTo('App\client' , 'company_id'   );
    }
}
