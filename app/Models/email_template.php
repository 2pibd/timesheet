<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class email_template extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_templates';

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
    protected $fillable = ['tplname', 'language_id','template_type_id', 'param', 'subject', 'message', 'status'];

    public function  template_type(){
        return $this->belongsTo('App\Models\template_type' , 'template_type_id'  );
    }
}
