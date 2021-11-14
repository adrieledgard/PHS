<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    //

    public $table = 'bank';
    public $primaryKey = 'Id_bank';
    public $timestamps = false;
    public $fillable = ['Id_bank','Bank_name','Account_number','Account_name','Bank_branch','Status'];
    public $incrementing = true;

    public function add_bank ($bank_name,$account_number,$account_name,$bank_branch)
    {
       
        
        bank::create(
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
