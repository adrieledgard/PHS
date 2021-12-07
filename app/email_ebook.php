<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class email_ebook extends Model
{
    protected $table="submitted_email_ebook";
    
    protected $fillable = ['ebook_id', 'email', 'user_token', 'date_request', 'status'];

    public function add_email_ebook($ebook_id, $email, $user_token)
    {
        email_ebook::create(
        [
            'Id_ebook' => null,
            'ebook_id' => $ebook_id,
            'user_token' => $user_token,
            'email' => $email,
            'date_request' => date("Y-m-d"),
            'status'=> 1
        ]
        );
        return "sukses";

    }
}
