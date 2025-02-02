<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segment_combination_user extends Model
{
    protected $fillable = ['seg_combination_setup_id', 'seg_comb_code','structure_code','client_id', 'head10', 'head1', 'head2' ,'head3', 'head4', 'head5' ,'head6', 'head7', 'head8' ,'head9' , 'default_user_id',  'status'];
    public function  header_value(){
        return $this->hasMany('App\Models\segment_combination_user_value', 'seg_com_users_id'    );
    }

    public function  segment_combosetup(){
        return $this->belongsTo('App\Models\segment_combination_setup', 'seg_combination_setup_id'    );
    }

    public function  seg_heads(){
        return $this->belongsTo('App\Models\segment_head' , 'head_id'  );
    }


    public function  segment_comb_header(){
        return $this->hasMany('App\Models\segment_combination_header' , 'segment_combination_user_id'  );
    }
}
