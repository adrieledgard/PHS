<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class email_ebook extends Model
{
    protected $table="submitted_email_ebook";
    
    protected $fillable = ['Ebook_id', 'Name', 'Phone' ,'Email', 'User_token', 'Date_request', 'Status'];

    public function add_email_ebook($ebook_id, $name, $phone, $email, $user_token)
    {
        email_ebook::create(
        [
            'Id_ebook' => null,
            'Ebook_id' => $ebook_id,
            'User_token' => $user_token,
            'Name' => $name,
            'Phone' => $phone,
            'Email' => $email,
            'Date_request' => date("Y-m-d"),
            'Status'=> 1
        ]
        );
        return "sukses";

    }

    public function getlastid()
    {
        $temp = email_ebook::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['id']>$c)
            {
                $c = $temp[$i]['id'];
            }
        }

        return $c;
    }
}
