<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidasiExpiredDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //

        try {
            $cart =  session()->get('purchase_product_session');
            $masuk = true;
            for ($i=0; $i < count($cart); $i++) { 
                $c=0;
                if($cart[$i]['Id']>=0) //JIKA ADA ID dibawah 0 Maka tidak di munculkan alias didelete
                {

                    for ($k=0; $k < count($cart[$i]['Qty_expire']) ; $k++)
                    {
                        $c = $c + $cart[$i]['Qty_expire'][$k];
                        // echo "<script language='javascript'>alert('".$c."')</script>";
                    }
        
                    if($cart[$i]['Qty_beli'] == $c)
                    {
                        
                    }
                    else
                    {
                        $masuk=false;
                    }

                }
                
            }
        } catch (\Throwable $th) {
            return true;
        }
       


        if($masuk==true)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Expired date is not complete';
    }
}
