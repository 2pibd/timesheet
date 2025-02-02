<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class industry_sub_sector extends Model
{
    protected $fillable = ['industry_id', 'sector_id', 'sector', 'status'];

}
