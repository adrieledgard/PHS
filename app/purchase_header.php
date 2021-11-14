<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_header extends Model
{
    public $table = 'purchase_header';
    public $primaryKey = 'No_invoice';
    public $timestamps = false;
    public $fillable = ['No_invoice','Purchase_date','Id_supplier','Grand_total','Status'];
    public $incrementing = false;


    public function insertdata ($No_invoice,$Purchase_date, $Id_suppllier, $Grand_total)
    {
       //STATUS
       //0 Void
       //1 Open (baru)
       //2 sdh datang sebagian barang tapi belum terpenuhi (posisi belum close)
       //3 sdh datang sebagian barang tapi belum terpenuhi (posisi close)
       //4 sdh datang dan sdh terpenuhi dan di close
      
        purchase_header::create(
        [
            'No_invoice' => strtoupper($No_invoice),
            'Purchase_date' => $Purchase_date,
            'Id_supplier' => strtoupper($Id_suppllier),
            'Grand_total' => strtoupper($Grand_total),
            'Status' => 1,
            

        ]
        );
        return "sukses";
    }

    public function editstatus($noinv,$status)
    {
        purchase_header::where('No_invoice','=',$noinv)->update(array(
            'Status'=>strtoupper($status),
            
        ));
        return "sukses";
    }
}
