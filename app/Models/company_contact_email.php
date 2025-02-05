<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company_contact_email extends Model
{
    protected $fillable = ['company_contact_id', 'email', 'is_default' ];

}
