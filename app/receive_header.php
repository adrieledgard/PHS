<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receive_header extends Model
{
    //

    //INV-RO-010121-0001
    public $table = 'receive_header';
    public $primaryKey = 'No_receive';
    public $timestamps = false;
    public $fillable = ['No_receive','No_invoice','Receive_date','Id_member','No_reff_supplier','Status','Payment'];
    public $incrementing = false;


    public function insertdata ($No_receive,$No_invoice, $Receive_date, $Id_member,$noreff)
    {
      
        receive_header::create(
        [
            'No_receive' => strtoupper($No_receive),
            'No_invoice' => strtoupper($No_invoice),
            'Receive_date' => strtoupper($Receive_date),
            'Id_member' => strtoupper($Id_member),
            'No_reff_supplier' => strtoupper($noreff),
            'Status' => 1,
            'Payment' =>0,
            

        ]
        );
        return "sukses";
       

    }

    public function insertdata2($No_receive,$No_invoice, $Receive_date, $Id_member,$noreff)
    {
      
        receive_header::create(
        [
            'No_receive' => strtoupper($No_receive),
            'No_invoice' => strtoupper($No_invoice),
            'Receive_date' => strtoupper($Receive_date),
            'Id_member' => strtoupper($Id_member),
            'No_reff_supplier' => strtoupper($noreff),
            'Status' => 2,
            'Payment' =>0,

        ]
        );
        return "sukses";
       

    }


    public function editstatus($No_receive,$Status)
    {
        receive_header::where('No_receive','=',$No_receive)->update(array(
            'Status'=>strtoupper($Status),
            
        ));
        return "sukses";
    }

    public function editpayment($No_receive,$Status)
    {
        receive_header::where('No_receive','=',$No_receive)->update(array(
            'Payment'=>strtoupper($Status),
            
        ));
        return "sukses";
    }
}
