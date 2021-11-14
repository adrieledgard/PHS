<?php

namespace App\Rules;
use App\supplier;

use Illuminate\Contracts\Validation\Rule;

class ValidasiSupplierName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     
    public $status;
    public $id_supplier;
    public function __construct($s,$id_supplier)
    {
        $this->status = $s;
        $this->id_supplier= $id_supplier; 
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
            $du = supplier::where('Supplier_name', '=', $value)
            ->get(); 
            
            if(count($du) == 0) { return true; } 
            else
            { return false; 
            
            }
        
        }
        else
        {
            $du = supplier::where('Supplier_name', '=', $value)
                ->where('Id_supplier','<>',$this->id_supplier)
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
        return 'Supplier name already exist';  

        // return ($this->id_supplier);
    }
}
