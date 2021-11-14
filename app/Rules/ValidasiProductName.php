<?php

namespace App\Rules;
use App\product;
use Illuminate\Contracts\Validation\Rule;

class ValidasiProductName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $status;
    public $id_product;
    public function __construct($s,$id_product)
    {
        //
        $this->status = $s;
        $this->id_product= $id_product; 

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
        if($this->status=="add")
        {
            $du = product::where('Name', '=', $value)
            ->get(); 
            
            if(count($du) == 0) { return true; } 
            else
            { return false; 
            
            }
        
        }
        else
        {
            $du = product::where('Name', '=', $value)
                ->where('Id_product','<>',$this->id_product)
            ->get(); 
            
            if(count($du) == 0) { return true; } 
            else
            { return false; 
            
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product name already register, please use another Product name';
    }
}
