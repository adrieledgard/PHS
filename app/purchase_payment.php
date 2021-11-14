<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_payment extends Model
{
    //
    public $table = 'purchase_payment';
    public $primaryKey = 'Id_purchase_payment';
    public $timestamps = false;
    public $fillable = ['Id_purchase_payment','Payment_date','No_receive','No_invoice','Id_member','Payment_method','Id_bank','Payment_image'];
    public $incrementing = false;


    public function insertdata($Id_purchase_payment,$Payment_date, $No_receive, $No_invoice,$Id_member, $Payment_method, $Id_bank, $Payment_image)
    {
       //STATUS
       //0 Void
       //1 Open (baru)
       //2 sdh datang sebagian barang tapi belum terpenuhi (posisi belum close)
       //3 sdh datang sebagian barang tapi belum terpenuhi (posisi close)
       //4 sdh datang dan sdh terpenuhi dan di close
      
        purchase_payment::create(
        [
            'Id_purchase_payment' => strtoupper($Id_purchase_payment),
            'Payment_date' => $Payment_date,
            'No_receive' => strtoupper($No_receive),
            'No_invoice' => strtoupper($No_invoice),
            'Id_member' => strtoupper($Id_member),
            'Payment_method' => strtoupper($Payment_method),
            'Id_bank' => strtoupper($Id_bank),
            'Payment_image' => strtoupper($Payment_image),
        ]
        );
        return "sukses";
    }

}
