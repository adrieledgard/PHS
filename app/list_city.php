<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class list_city extends Model
{

    public $table = 'list_city';
    public $primaryKey = 'Id_city';
    public $timestamps = false;
    public $fillable = ['Id_city','Id_province','Province_name','Type','City_name','Post_code'];
    public $incrementing = false;
    //
}
