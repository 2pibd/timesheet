<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
    protected $fillable = ['client_id', 'company_name','external_ref', 'company_email', 'company_phone', 'industry_type', 'company_id','vat_reg', 'address', 'website', 'company_profile',
        'base_path','base_url', 'company_logo', 'top_company','default_currency','default_lang','code_length',
        'address1','address2','address3','address4', 'address5','city','state','postcode','country','html_cv',
        'default_compliance_group', 'status','post_by'];



    public function  postby(){
        return $this->belongsTo('App\Models\User' , 'post_by'  );
    }
    public function  account(){
        return $this->belongsTo('App\Models\User' , 'user_id','id'  );
    }

    public function  company_billing_address(){
        return $this->hasMany('App\Models\client_address' , 'company_id'   );
    }

    public function industrytype(){
        return $this->belongsTo('App\Models\industry', 'industry_type' , 'industry_id' );
    }

    public function language(){
        return $this->belongsTo('App\Models\language', 'default_lang'   );
    }

    public function  company_contact_parson(){
        return $this->hasMany('App\Models\client_contact_info' , 'company_id' );
    }

}
