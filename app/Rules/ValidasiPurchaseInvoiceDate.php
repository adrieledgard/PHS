<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\DateTime;

class ValidasiPurchaseInvoiceDate implements Rule
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
        $todayDate = date("d/m/Y");

        $todayDate2 = strtotime($todayDate); 
        $todayDate3 = getDate($todayDate2); 


        $newDate = $value;

        $newDate2 = strtotime($newDate); 
        $newDate3 = getDate($newDate2); 


        // echo "<script language='javascript'> alert('".$newDate3['year']."')</script>";
       // echo "<script> alert('".$newDate3."')</script>";

        if($newDate3>$todayDate3)
        {
            return false;
        }
        else
        {
            return true;
        }

       
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Incoice date cannot greater than today';
    }
}
