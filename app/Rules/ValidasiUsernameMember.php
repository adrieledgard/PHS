<?php

namespace App\Rules;
use App\member;

use Illuminate\Contracts\Validation\Rule;

class ValidasiUsernameMember implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     
    public $status;
    public $id_member;

    public function __construct($s,$id_member)
    {
        //
        $this->status = $s;
        $this->id_member = $id_member; 
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
        if($this->status=="add")
        {
            $du = member::where('Username', '=', $value)
            ->get(); 
            
            if(count($du) == 0) { return true; } 
            else
            { return false; 
            
            }
        
        }
        else
        {
            $du = member::where('Username', '=', $value)
                ->where('Id_member','<>',$this->id_member)
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
        return 'Username Already Register, please use another email';
    }
}
