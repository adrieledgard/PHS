<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ebook extends Model
{
    //

    public $table = 'ebook';
    public $primaryKey = 'Id_ebook';
    public $timestamps = false;
    public $fillable = ['Id_ebook','Id_template','Title','Content','Image','Pdf_file','Call_to_action','Status'];
    public $incrementing = true;

    public function add_ebook($Id_ebook,$Id_template,$Title,$Content)
    {
        ebook::create(
        [
            'Id_brand' => null,
            'Bank_name' => strtoupper($bank_name),
            'Account_number' => strtoupper($account_number),
            'Account_name' => strtoupper($account_name),
            'Bank_branch' => strtoupper($bank_branch),
            'Status'=>1
        ]
        );
        return "sukses";
    


    }


    public function edit_bank ($id,$bank_name,$account_number,$account_name,$bank_branch)
    {
      
        bank::where('Id_bank','=',$id)->update(array(
            'Bank_name' => strtoupper($bank_name),
            'Account_number' => strtoupper($account_number),
            'Account_name' => strtoupper($account_name),
            'Bank_branch' => strtoupper($bank_branch),
        ));
        return "sukses";
      

    }

    public function getbank($id)
    {
        return bank::where('Id_bank', '=', $id)
        ->where('Status','=',1)
                        ->get();
    }

    public function deletebank($Id_bank)
    {
        bank::where('Id_bank','=',$Id_bank)->update(array(
            'Status' => 0
        ));
    }
}
