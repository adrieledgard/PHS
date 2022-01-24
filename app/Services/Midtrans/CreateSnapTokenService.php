<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;
    protected $detail; 

    public function __construct($order, $detail)
    {
        parent::__construct();

        $this->order = $order;
        $this->detail= $detail;
    }

    public function getSnapToken()
    {
        $grandtotal = 0; 
        $arritems = []; 
        foreach($this->detail as $rowdet) 
        {
            $baru = [
                'id' => $rowdet->Id_product,
                'price' => $rowdet->Fix_price,
                'quantity' => $rowdet->Qty,
                'name' => $rowdet->Name.'-'.$rowdet->Option_name,
            ];
            $grandtotal += $rowdet->Fix_price * $rowdet->Qty; 
            array_push($arritems, $baru); 
        }

        $baru = [
            'id' => 999,
            'price' =>  $this->order->Shipping_cost,
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];
        $grandtotal += $this->order->Shipping_cost;
        array_push($arritems, $baru);




        $baru = [
            'id' => 999,
            'price' =>  "-".$this->order->Discount,
            'quantity' => 1,
            'name' => 'Discount Voucher',
        ];
        $grandtotal -= $this->order->Discount;
        array_push($arritems, $baru);




        $params = [
            'transaction_details' => [
                'order_id' => $this->order->Id_order,
                'gross_amount' => $grandtotal,
            ],
            'item_details' => $arritems, 
            'customer_details' => [
                'first_name' => $this->order->Name,
                'email' => $this->order->Email,
                'phone' => $this->order->Phone,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}