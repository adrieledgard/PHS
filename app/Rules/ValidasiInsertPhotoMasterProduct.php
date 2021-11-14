<?php

namespace App\Rules;
use App\product_image;

use Illuminate\Contracts\Validation\Rule;

class ValidasiInsertPhotoMasterProduct implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
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

        $data = product_image::where('Id_product', '=', $this->id)
        ->get(); 
        
        if(count($data) > 3) { return false; }   
        else  
        { return true;   
      
    }  
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product images max 4';
    }
}
