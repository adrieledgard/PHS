<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    //
    public $table = 'supplier';
    public $primaryKey = 'Id_supplier';
    public $timestamps = false;
    public $fillable = ['Id_supplier','Supplier_name','Supplier_email','Supplier_phone1','Supplier_phone2','Supplier_address','Credit_due_date','Status'];
    public $incrementing = true;

    public function add_supplier ($name,$email,$phone1,$phone2,$address,$credit)
    {
       
   
        supplier::create(
        [
            'Id_supplier' => null,
            'Supplier_name' => strtoupper($name),
            'Supplier_email' => strtoupper($email),
            'Supplier_phone1' => strtoupper($phone1),
            'Supplier_phone2' => strtoupper($phone2),
            'Supplier_address' => strtoupper($address),
            'Credit_due_date' => strtoupper($credit),
            'Status' => 1,
        ]
        );
        return "sukses";
        


    }


    public function edit_supplier ($id,$name,$email,$phone1,$phone2,$address,$credit)
    {
     
        supplier::where('Id_supplier','=',$id)->update(array(
            'Supplier_name'=>strtoupper($name),
            'Supplier_email'=>strtoupper($email),
            'Supplier_phone1'=>strtoupper($phone1),
            'Supplier_phone2'=>strtoupper($phone2),
            'Supplier_address'=>strtoupper($address),
            'Credit_due_date' => strtoupper($credit),
        ));
        return "sukses";
     
    }

    public function getsupplier($id)
    {
        return supplier::where('Id_supplier', '=', $id)
                        ->get();
    }

    public function getlastid()
    {
        $temp = supplier::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['Id_supplier']>$c)
            {
                $c = $temp[$i]['Id_supplier'];
            }
        }

        return $c;
    }
}
