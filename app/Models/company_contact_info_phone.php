<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company_contact_info_phone extends Model
{
    protected $fillable = ['company_contact_info_id', 'type', 'phone_code', 'phone', 'is_default' ];

}
