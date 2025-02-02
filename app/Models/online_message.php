<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class online_message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'online_messages';

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
    protected $fillable = ['message_type', 'offline_title', 'offline_message', 'message'];

    public function online_message_user()
    {
        return $this->hasMany('App\Models\online_message_to_users' ,  'online_message_id' );
    }
}
