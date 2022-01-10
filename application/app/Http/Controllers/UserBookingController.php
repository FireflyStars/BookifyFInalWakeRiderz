<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\BookingSlot;
use App\BookingTime;
use App\Category;
use App\CouponCode;
use App\Package;
use App\StaffMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

class UserBookingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | User Booking Controller
    |--------------------------------------------------------------------------
    |
    | This controller loads all frontend booking views and process
    | all requests. Also loads specific user's bookings to view.
    |
    */


    /**
     * get user bookings and load user bookings view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()->orderBy('created_at', 'ASC')->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Initialize a booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadBooking()
    {
        $random_pass_string = str_random(10);
        $categories = Category::all();
        return view('welcome', compact('random_pass_string', 'categories'));
    }

    /**
     * AJAX request to load packages.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackages()
    {
        $category_id = \request('parent');
        $packages = Category::find($category_id)->packages()->get();
        return view('blocks.packages', compact('packages'));
    }

    /**
     * Get timing slots for frontend booking.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTimingSlots()
    {
        //get selected event date and staff
        $event_date = \request('event_date');
        $staff_member_id = \request('staff_member_id');
        $selected_package_id = Session::get('package_id');


        //get day name to select slot timings
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);
        $booking_time = BookingTime::findOrFail($today_number);

        $slots = BookingSlot::all()->where('booking_time_id', '=', $booking_time->id);

        //get all bookings to block some already booked slots
        $bookings = Booking::all()
            ->where('status', '!=',__('backend.cancelled'))
            ->where('staff_member_id', '=', $staff_member_id);

        $i = 0;
        foreach ($slots as $slot)
        {
            $list_slot[$i]['slot'] = $slot->opening." - ".$slot->closing;

            if(count($bookings))
            {
                foreach ($bookings as $booking)
                {
                    if($booking->booking_time === $list_slot[$i]['slot'] && $booking->booking_date === $event_date && $booking->package->id == $selected_package_id)
                    {
                        $list_slot[$i]['is_available'] = false;
                        break;
                    }
                    else
                    {
                        if($slot->is_disabled)
                        {
                            $list_slot[$i]['is_available'] = false;
                        }
                        else
                        {
                            $list_slot[$i]['is_available'] = true;
                        }
                    }
                }
            }
            else
            {
                if($slot->is_disabled)
                {
                    $list_slot[$i]['is_available'] = false;
                }
                else
                {
                    $list_slot[$i]['is_available'] = true;
                }
            }

            $i++;
        }

        $hours = $i;


        return view('blocks.slots', compact('list_slot', 'hours'));
    }

    /**
     * Get timing slots for updating booking.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateSlots()
    {
        $event_date = \request('event_date');
        $booking_id = \request('booking');
        $booking = Booking::find($booking_id);
        $staff_member_id = $booking->staff_member_id;

        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);

        //get related booking time for day number
        $booking_time = BookingTime::findOrFail($today_number);

        $slots = BookingSlot::all()->where('booking_time_id', '=', $booking_time->id);

        //get all bookings to block some already booked slots
        $bookings = Booking::all()
            ->where('status', '!=',__('backend.cancelled'))
            ->where('staff_member_id', '=', $staff_member_id);

        $i = 0;
        foreach ($slots as $slot)
        {
            $list_slot[$i]['slot'] = $slot->opening." - ".$slot->closing;

            if(count($bookings))
            {
                foreach ($bookings as $booking)
                {
                    if($booking->booking_time === $list_slot[$i]['slot'] && $booking->booking_date === $event_date)
                    {
                        $list_slot[$i]['is_available'] = false;
                        break;
                    }
                    else
                    {
                        if($slot->is_disabled)
                        {
                            $list_slot[$i]['is_available'] = false;
                        }
                        else
                        {
                            $list_slot[$i]['is_available'] = true;
                        }
                    }
                }
            }
            else
            {
                if($slot->is_disabled)
                {
                    $list_slot[$i]['is_available'] = false;
                }
                else
                {
                    $list_slot[$i]['is_available'] = true;
                }
            }


            $i++;
        }

        $hours = $i;

        return view('blocks.backendSlots', compact('list_slot', 'hours'));

    }

    /**
     * Change booking time.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update_booking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if($booking->user->id == auth()->user()->id)
        {
            $input = $request->all();

            //update booking
            $booking->update([
                'booking_date' => $input['event_date_bk'],
                'booking_time' => $input['booking_slot']
            ]);

            //if sync is enabled and booking have calender event_id
            if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != NULL) {

                //create new timestamp
                $time_string = $input['event_date_bk'] . " " . $input['booking_slot'];
                $start_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'));
                $end_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'))->addMinutes($booking->package->duration);

                try{
                    //update google calendar event
                    $event = Event::find($booking->google_calendar_event_id);
                    $event->startDateTime = $start_instance;
                    $event->endDateTime = $end_instance;
                    $event->save();
                } catch(\Exception $ex) {
                    //do nothing
                }

            }

        }

        Session::flash('time_updated', __('backend.booking_time_updated'));
        return redirect()->route('customerBookings');

    }

    /**
     * Handle post of booking step 1.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postStep1(Request $request)
    {
        $input = $request->all();
        $package = Package::find($input['package_id']);
        $category_id = $package->category->id;

        $request->session()->put('package_id', $input['package_id']);
        $request->session()->put('category_id', $category_id);

        return redirect()->route('loadStep2');
    }

    /**
     * Load booking step 2.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep2()
    {
        //generating a string for off days
        $off_days = DB::table('booking_times')
            ->where('is_off_day', '=', '1')
            ->get();

        $day_number = array();

        foreach ($off_days as $off_day)
        {
            if($off_day->id != 7)
            {
                $day_number[] = $off_day->id;
            }
            else
            {
                $day_number[] = $off_day->id - 7;
            }
        }

        $disable_days_string = implode(",", $day_number);

        //generate a list of staff members
        $staff_ids = DB::table('staff_member_services')->where('category_id','=', Session::get('category_id'))->get();
        $list_staff = [];
        $counter = 0;

        foreach ($staff_ids as $staff_id)
        {
            $staff = StaffMember::find($staff_id->staff_member_id);
            $list_staff[$counter]['id'] = $staff->id;
            $list_staff[$counter]['name'] = $staff->first_name." ".$staff->last_name;
            $counter++;
        }

        //load step 2
        return view('select-booking-time', compact('disable_days_string', 'list_staff', 'counter'));
    }

    /**
     * Handle post of booking step 2.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postStep2(Request $request)
    {
        $input = $request->all();

        //store form input into session and load next step
        $request->session()->put('staff_member_id', $input['staff_member_id']);
        $request->session()->put('event_date', $input['event_date']);
        $request->session()->put('instructions', $input['instructions']);
        $request->session()->put('booking_slot', $input['booking_slot']);
        $request->session()->put('address', $input['address']);
        $request->session()->put('city', $input['city']);
        $request->session()->put('state', $input['state']);
        $request->session()->put('zip', $input['zip']);
        $request->session()->put('group_size', $input['group_size']);
        $request->session()->put('event_type', $input['event_type']);

        return redirect('/select-extra-services');
    }

    /**
     * Load Step 3.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep3()
    {
        $package_id = Session::get('package_id');
        $package = Package::find($package_id);
        $category_id = $package->category_id;

        //select all addons of category
        $addons = Category::find($category_id)->addons()->get();
        $session_addons = DB::table('session_addons')->where('session_email','=',auth()->user()->email)->get();

        return view('select-extra-services', compact('addons', 'session_addons'));
    }

    /**
     * Handle post of booking step 3.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postStep3(Request $request)
    {
        return redirect('/finalize-booking');
    }

    /**
     * Load final booking Step.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadFinalStep()
    {
        $event_address = str_replace(' ', '+', Session::get('address'));
        $category = Package::find(Session::get('package_id'))->category->title;
        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email','=',auth()->user()->email)->get();

        //calculate total
        $total = $package->price;

        //add addons price if any
        foreach($session_addons as $session_addon)
        {
            $total = $total + Addon::find($session_addon->addon_id)->price;
        }

        if(Session::get('discount'))
        {
            $discount = (Session::get('discount')/100) * $total;
            $total = $total - $discount;
        }

        //check if GST is enabled and add it to total invoice
        if(config('settings.enable_gst'))
        {
            $gst_amount = ( config('settings.gst_percentage') / 100 ) * $total;
            $gst_amount = round($gst_amount,2);
            $total_with_gst = $total + $gst_amount;
            $total_with_gst = round($total_with_gst,2);
        }

        return view('finalize-booking', compact('event_address', 'category',
            'package', 'session_addons', 'total', 'total_with_gst', 'gst_amount', 'discount'));
    }

    /**
     *
     * Thank you - payment completed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thankYou()
    {
        return view('thank-you');
    }

    /**
     * Payment failed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentFailed()
    {
        return view('payment-failed');
    }

    /**
     *
     * Show booking to customer
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $booking = Booking::find($id);

        //checking booking date to allow update or cancel
        $days_limit_to_update = config('settings.days_limit_to_update') * 86400;
        $days_limit_to_cancel = config('settings.days_limit_to_cancel') * 86400;
        $today = date('Y-m-d');

        if(strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_update)
        {
            $allow_to_update = true;
        }
        else
        {
            $allow_to_update = false;
        }

        if(strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_cancel)
        {
            $allow_to_cancel = true;
        }
        else
        {
            $allow_to_cancel = false;
        }

        return view('customer.bookings.view' , compact('booking','allow_to_update', 'allow_to_cancel'));
    }

    /**
     *
     * Remove addon from list of booking services
     */
    public function removeFromList()
    {
        $addon_id = \request('addon_id');
        $session_email = \request('session_email');
        DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email','=',$session_email)->delete();
    }

    /**
     *
     * check if addon is added in list of booking services
     * @param $addon_id
     * @param $session_email
     * @return int
     */
    public function checkIfAdded($addon_id,$session_email)
    {
        $row = DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email','=',$session_email)->get();
        if(count($row)==0)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /**
     *
     * load booking update view for user
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        $booking = Booking::find($id);

        $cancel_request = $booking->cancel_request()->first();

        //generating a string for off days
        $off_days = DB::table('booking_times')
            ->where('is_off_day', '=', '1')
            ->get();


        $day_number = array();

        foreach ($off_days as $off_day)
        {
            if($off_day->id != 7)
            {
                $day_number[] = $off_day->id;
            }
            else
            {
                $day_number[] = $off_day->id - 7;
            }
        }

        $disable_days_string = implode(",", $day_number);

        if($booking->user->id == auth()->user()->id && $booking->status != __('backend.cancelled') && count($cancel_request)==0)
        {
            return view('customer.bookings.update', compact('booking', 'disable_days_string'));
        }
        else
        {
            return view('errors.404');
        }
    }

    public function usePromo(Request $request)
    {
        $code = $request->only('code');

        //match code first
        $coupon = CouponCode::where('code', '=', $code)->first();

        if($coupon)
        {
            //check if code is not used max times
            if($coupon->max_uses !== $coupon->used)
            {
                //coupon can be used - check for validity of dates
                $today = date('d-m-Y');
                if(strtotime($coupon->valid_from) <= strtotime($today) && strtotime($coupon->valid_to) >= strtotime($today))
                {
                    $categories = $coupon->categories()->get();
                    $is_supported = false;
                    foreach ($categories as $category)
                    {
                        if($category->id == Session::get('category_id'))
                        {
                            $is_supported =  true;
                            break;
                        }
                    }

                    if($is_supported)
                    {
                        //promo is all good, calculate discount
                        Session::put('promo_code_id', $coupon->id);
                        Session::put('promo_code', $coupon->code);
                        Session::put('discount', $coupon->percentage);

                        $category = Package::find(Session::get('package_id'))->category->title;
                        $package = Package::find(Session::get('package_id'));
                        $session_addons = DB::table('session_addons')->where('session_email','=',auth()->user()->email)->get();

                        //calculate total
                        $total = $package->price;

                        //add addons price if any
                        foreach($session_addons as $session_addon)
                        {
                            $total = $total + Addon::find($session_addon->addon_id)->price;
                        }

                        if(Session::get('discount'))
                        {
                            $discount = (Session::get('discount')/100) * $total;
                            $total = $total - $discount;
                        }

                        //check if GST is enabled and add it to total invoice
                        if(config('settings.enable_gst'))
                        {
                            $gst_amount = ( config('settings.gst_percentage') / 100 ) * $total;
                            $gst_amount = round($gst_amount,2);
                            $total_with_gst = $total + $gst_amount;
                            $total_with_gst = round($total_with_gst,2);
                        }

                        return view('blocks.pricing', compact('package', 'session_addons', 'total', 'gst_amount', 'total_with_gst', 'category', 'discount'));
                    }
                    else
                    {
                        return "wrong_category";
                    }
                }
                else
                {
                    return "expired";
                }
            }
            else
            {
                return "max_used";
            }
        }
        else
        {
            return "404";
        }
    }

}