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
    protected $fillable = ['employer_id', 'supplier_ref', 'business_name', 'department', 'division', 'legal_status', 'supplier_type', 'remittance_to', 'payment_option', 'incorpotrate_date', 'company_reg_no', 'schedule_date', 'number', 'vat_number', 'vat_area', 'vat_rate', 'payment_terms'];

    
}
