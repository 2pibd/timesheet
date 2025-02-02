<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';

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
    protected $fillable = ['invoice_number', 'invoice_contact', 'invoice_date', 'employer_ref', 'tax_year', 'posted_to', 'invoice_printed', 'invoice_net', 'invoice_vat', 'invoice_total'];

    
}
