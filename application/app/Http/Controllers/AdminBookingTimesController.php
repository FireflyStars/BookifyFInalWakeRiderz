<?php

namespace App\Http\Controllers;

use App\BookingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminBookingTimesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Booking Times Controller
    |--------------------------------------------------------------------------
    |
    |   This controller loads the views to edit booking times for whole week
        and let admin update the times.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking_times = BookingTime::all();
        return view('settings.bookingTimes', compact('booking_times'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        BookingTime::findOrFail($id)->update($input);

        //set session message and redirect back booking-times.index
        Session::flash('booking_time_updated', __('backend.booking_time_updated'));
        return redirect()->route('booking-times.index');
    }

}
