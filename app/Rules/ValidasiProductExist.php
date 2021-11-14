<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidasiProductExist implements Rule
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
            //code...
            $cart = session()->get('purchase_product_session');
            $ada=false;

            for ($i=0; $i < count($cart); $i++) { 
                if($cart[$i]['Id']>=0) //JIKA ADA ID dibawah 0 Maka tidak di munculkan alias didelete
                {
                    $ada=true;

                }
            }

            if($ada==true)
            {
                return true;
            }
            else
            {
                return false;
            }
            
              
        } catch (\Throwable $th) {
            //throw $th;
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
        return 'Please Choose at least one product';
    }
}
