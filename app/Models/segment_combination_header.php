<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_combination_header extends Model
{
    protected $fillable = ['segment_combination_setup_id', 'segment_combination_user_id','head_id' ];


    public function  seg_heads(){
        return $this->belongsTo('App\Models\segment_head' , 'head_id'  );
    }
}
