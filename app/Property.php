<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name','city','description','total_rooms','price','images'];

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
