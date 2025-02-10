<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

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
    protected $fillable = ['employer_id', 'email', 'supplier_ref', 'business_name', 'contact_number', 'department_ref', 'division_ref', 'legal_status',
        'supplier_type', 'remittance_to', 'payment_option', 'incorporate_date', 'company_reg_no', 'schedule_date', 'number', 'vat_number', 'vat_area',
        'vat_rate', 'payment_terms','current_code','address_line1','address_line2','address_line3','address_line4','address_line5','post_code','country_id'];

    public function client(){
        return  $this->belongsTo('App\Models\client','client_ref','external_ref');
    }
    public function division(){
        return  $this->belongsTo('App\Models\division','division_ref','ref_code');
    }
    public function department(){
        return  $this->belongsTo('App\Models\department','department_ref','ref_code');
    }

    public function supplier_type(){
        return  $this->belongsTo('App\Models\placement_type', 'supplier_type');
    }
}
