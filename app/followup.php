<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class followup extends Model
{
    protected $table = "followup_customers";
    protected $fillable = ['Id_customer_service', 'Id_member', 'Followup_date', 'End_followup_date','Is_successful_followup', 'Count_followup'];

    public function add_followup($Id_customer_service, $Id_member,$Followup_date,$End_followup_date)
    {
        followup::create(
        [
            'Id_followup' => null,
            'Id_customer_service' => $Id_customer_service,
            'Id_member' => $Id_member,
            'Followup_date' => $Followup_date,
            'End_followup_date' => $End_followup_date,
            'Count_followup' => 1,
            'Is_successful_followup' => 0,
        ]
        );
        return "sukses";

    }

    public function edit_followup($Id_customer_service, $Id_member,$Followup_date,$End_followup_date, $count_followup)
    {
        followup::where('Id_customer_service','=',$Id_customer_service)->where('Id_member', $Id_member)->update(
            [
                'Followup_date' => $Followup_date,
                'End_followup_date' => $End_followup_date,
                'Count_followup' => $count_followup,
                'Is_successful_followup' => 0,
            ]
            );

        return "sukses";
    }

    public function followup_successful($Id_customer_service, $Id_member)
    {
        followup::where('Id_customer_service','=',$Id_customer_service)->where('Id_member', $Id_member)->update(
            [
                'Is_successful_followup' => 1,
            ]
            );

        return "sukses";
    }
}
