<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class followup extends Model
{
    protected $table = "followup_customers";
    protected $fillable = ['Id_customer_service', 'Id_voucher', 'Id_member', 'Followup_date', 'Is_successful_followup', 'Successful_followup_date'];
}
