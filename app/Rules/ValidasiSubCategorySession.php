<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidasiSubCategorySession implements Rule
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
            $cart = session()->get('datasubcategory');

            if(count($cart)<=0)
            {
            return false;
            }
            else
            {
                return true;
            }                       
        } catch (\Throwable $th) {
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
        return 'Please choose at least one sub-category';
    }
}
