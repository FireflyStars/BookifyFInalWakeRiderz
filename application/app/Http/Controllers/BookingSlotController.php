<?php

namespace App\Http\Controllers;

use App\BookingSlot;
use App\BookingTime;
use App\Http\Requests\SlotRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class BookingSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        $day = BookingTime::find($id);
        $slots = $day->slots()->get();
        return view('booking_slots.index', compact('day', 'slots'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param SlotRequest $request
     * @param $id
     * @return Response
     */
    public function store(SlotRequest $request, $id)
    {
        $day = BookingTime::find($id);
        $input = $request->all();
        $day->slots()->create($input);

        Session::flash('slot_created', 'New slot is created successfully.');
        return redirect()->route('booking-slots.index', $id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param $slot_id
     * @return Response
     */
    public function update(Request $request, $id, $slot_id)
    {
        $slot = BookingSlot::find($slot_id);
        $input = $request->all();

        $slot->update($input);

        Session::flash('slot_updated', 'Selected slot is updated successfully.');
        return redirect()->route('booking-slots.index', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param $slot_id
     * @return Response
     */
    public function destroy($id, $slot_id)
    {
        BookingSlot::destroy($slot_id);

        Session::flash('slot_deleted', 'Selected slot is deleted successfully.');
        return redirect()->route('booking-slots.index', $id);
    }
}
