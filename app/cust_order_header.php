<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cust_order_header extends Model
{
    //

    public $table = 'cust_order_header';
    public $primaryKey = 'Id_order';
    public $timestamps = false;
    public $fillable = ['Id_order','Date_time','Id_member','Address','Id_province',
                        'Id_city','Name','Email','Phone','Courier','Courier_packet','Affiliate','Id_voucher'
                        ,'Weight','Gross_total','Shipping_cost','Discount','Grand_total','Shipper','Status'];
    public $incrementing = true;


    
    public function insertdata ($Date_time, $Id_member, $Address, $Id_province,$Id_city,
    $Name,$Email, $Phone, $Courier, $Courier_packet, $Affiliate, $Id_voucher, $Weight, $Gross_total, $Shipping_cost
    ,$Discount,$Grand_total,$Shipper,$Status)
    {
       
      
        cust_order_header::create(
        [
            'Id_order' => null,
            'Date_time' => ($Date_time),
            'Id_member' => ($Id_member),
            'Address' => ($Address),
            'Id_province' => $Id_province,
            'Id_city' => $Id_city,
            'Name' => $Name,
            'Email' => ($Email),
            'Phone' => $Phone,
            'Courier' => $Courier,
            'Courier_packet' => $Courier_packet,
            'Affiliate' => $Affiliate,
            'Id_voucher' => $Id_voucher,
            'Weight' => $Weight,
            'Gross_total' => $Gross_total,
            'Shipping_cost' => $Shipping_cost,
            'Discount' => $Discount,
            'Grand_total' => $Grand_total,
            'Shipper' => $Shipper,
            'Status' => $Status,

        ]
        );
        return "sukses";
       

    }

    public function getlastinvoice()
    {
        $temp = cust_order_header::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['Id_order']>$c)
            {
                $c = $temp[$i]['Id_order'];
            }
        }

        return $c;
    }

}
