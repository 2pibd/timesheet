<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_combination_setup_value extends Model
{
    //
    protected $fillable = ['seg_combination_setup_id', 'client_id', 'head_id', 'segment_value_id', 'order_by' ,   'status'];

    public function  head_details(){
        return $this->hasMany('App\Models\segment_head_detail' ,  'seg_head_id', 'head_id' );
    }
    public function  seg_head(){
        return $this->belongsTo('App\Models\segment_head' , 'head_id'  );
    }

    public function  clients(){
        return $this->belongsTo('App\Models\client', 'client_id', 'id');
    }

    public function  com_head_value(){
        return $this->hasMany('App\Models\segment_combination_setup_value', 'head_id', 'head_id');
    }

    public function  com_head_seg_detail(){
        return $this->belongsTo('App\Models\segment_head_detail', 'segment_value_id' );
    }

    public function  allocated_user(){
        return $this->hasMany('App\Models\segment_user_allocation', 'seg_combination_setup_id' );
    }


    public function  combo_code(){
        return $this->belongsTo('App\Models\segment_combination_setup', 'seg_combination_setup_id' );
    }


}
