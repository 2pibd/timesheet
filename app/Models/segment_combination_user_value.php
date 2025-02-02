<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_combination_user_value extends Model
{
    protected $fillable = ['parent_id','seg_com_setup_id','seg_com_users_id', 'head_id','head_value_id'];

    public function  headerdetails(){
        return $this->belongsTo('App\Models\segment_head_detail', 'head_value_id'     );
    }

    public function  header(){
        return $this->belongsTo('App\Models\segment_head', 'head_id'     );
    }

}
