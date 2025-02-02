<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class faq extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

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
    protected $fillable = ['faq_title', 'faq_desc', 'category','language_id', 'client', 'worker', 'supplier','hide', 'employer_id','viewed','status'];

    public function language(){
        return $this->belongsTo('App\Models\language', 'language_id'   );
    }
    public function employer(){
        return $this->belongsTo('App\Models\employer', 'employer_id'   );
    }

}
