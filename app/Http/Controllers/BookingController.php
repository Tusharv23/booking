<?php

namespace App\Http\Controllers;

use App\Booking;//model to interact with database.
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        //This function will return all the bookings.
        $bookings = Booking::all();
        return $bookings;
    }

    public function store(Request $request, $propertyId)
    {
        //This function will store booking a particular user.
        $inputs = $request->all();
        if($this->checkAvailability($propertyId, new Carbon($inputs["check_in"]), new Carbon($inputs["check_out"]),$inputs["room_quantity"])){
            $booking = new Booking;
            $booking->user_details = $inputs["user_details"];
            $booking->check_in = new Carbon($inputs["check_in"]);
            $booking->check_out = new Carbon($inputs["check_out"]);
            $booking->room_quantity = $inputs["room_quantity"];
            $booking->property_id = $propertyId;
            $booking->save();
            return $booking;
        }
        else{
            return '{ "error": "Room unavailable for the respected dates" }';
        }
    }

    public function checkAvailability($propertyId, $check_in, $check_out, $room_quantity){
        //This function is used to check whether rooms are available of a specified property on specified dates.
        $count = 0;
        $property = \App\Property::find($propertyId);
        $totalRooms = \App\Property::where('id',$propertyId)->pluck('total_rooms');
        foreach($property->bookings as $booked){

            if(($check_in->lessThanOrEqualTo($booked->check_in)&&$check_out->between($booked->check_in,$booked->check_out))||($check_out->between($booked->check_in,$booked->check_out)&&$check_in->between($booked->check_in,$booked->check_out))||($check_in->between($booked->check_in,$booked->check_out)&&$check_out->greaterThanOrEqualTo($booked->check_out))){
                $count=$count+$booked->room_quantity;
            }
        }
        if($totalRooms[0] >= $count + $room_quantity){
            return true;
        }else{
            return false;
        }
    }

    public function show(Booking $booking, $propertyId)
    {
        //This function will return bookings of a specified property.
        $bookingForProperty = \App\Property::find($propertyId)->bookings;
        return $bookingForProperty;
    }
}
