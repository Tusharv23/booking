<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = ['user_details','property_id','check_in','check_out','room_quantity'];
    protected $dates = [
        'check_in',
        'check_out'
    ];
}
