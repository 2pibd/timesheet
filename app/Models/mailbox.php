<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mailbox extends Model
{
    protected $fillable = ['site_ref_id','user_id', 'subject', 'message', 'token','flag' ,'from_name', 'from_mail','to_mail','date','token'];

    public function attachment(){
        return $this->hasMany('App\mail_attachment','mailbox_id'   );
    }

}
