<?php

namespace App\Http\Controllers;

use App\Addon;
use App\CouponCode;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Package;
use App\Role;
use App\Booking;
use App\SessionAddon;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

class StripeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Stripe Controller
    |--------------------------------------------------------------------------
    |
    | This controller accepts the form post of credit card payment form
    | containing $request[stripe-token] to capture payment. It calculates
    | booking charges, capture payment, save booking and send emails.
    |
    */

    /**
     * Accept form post and process payment and booking
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payWithStripe(Request $request)
    {
        //calculate total amount to be charged
        $package_id = Session::get('package_id');
        $package = Package::find($package_id);
        $session_addons = SessionAddon::all()->where('session_email','=', auth()->user()->email);

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
        $total_with_gst = 0;
        if(config('settings.enable_gst'))
        {
            $gst_amount = ( config('settings.gst_percentage') / 100 ) * $total;
            $gst_amount = round($gst_amount,2);
            $total_with_gst = $total + $gst_amount;
        }

        //decide if to charge with GST or without GST
        if(config('settings.enable_gst'))
        {
            $amount_to_charge = $total_with_gst;
        }
        else
        {
            $amount_to_charge = $total;
        }

        if(config('settings.stripe_processing_fee'))
        {
            $amount_to_charge = $amount_to_charge + config('settings.stripe_processing_fee');
        }

        try {
            //create stripe charge and capture immediately
            $charge = Stripe::charges()->create([
                'currency' => config('settings.default_currency'),
                'amount'   => $amount_to_charge,
                'source'   => $request['stripe-token'],
                'description' => config('settings.business_name')." Booking",
                'statement_descriptor' => config('settings.business_name')." Booking",
                'capture' => true,
            ]);
        } catch (\Exception $ex) {
            //set error message and redirect back
            Session::flash('stripe_error', $ex->getMessage());
            return redirect()->route('loadFinalStep');
        }

        //charge captured, check charge status and save booking + invoice with $charge['id']
        if($charge['status']=="succeeded")
        {
            //if sync is enabled
            if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id'))
            {
                //create timestamp
                $time_string = Session::get('event_date')." ".Session::get('booking_slot');
                $start_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'));
                $end_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'))->addMinutes($package->duration);

                try {

                    //create google calendar event
                    $event = new Event;
                    $event->name = $package->category->title." - ".$package->title." ".__('app.booking')." - ".__('backend.processing');
                    $event->startDateTime = $start_instance;
                    $event->endDateTime = $end_instance;
                    $calendarEvent = $event->save();

                    //create booking with calender event id
                    $booking = Booking::create([
                        'user_id' => auth()->user()->id,
                        'package_id' => $package->id,
                        'booking_address' => Session::get('address'),
                        'booking_instructions' => Session::get('instructions'),
                        'booking_date' => Session::get('event_date'),
                        'booking_time' => Session::get('booking_slot'),
                        'google_calendar_event_id' => $calendarEvent->id,
                        'status' => __('backend.processing'),
                        'staff_member_id' => Session::get('staff_member_id'),
                        'city' => Session::get('city'),
                        'state' => Session::get('state'),
                        'zip' => Session::get('zip'),
                        'group_size' => Session::get('group_size'),
                        'event_type' => Session::get('event_type'),
                        'promo_used' => Session::get('promo_code') ? Session::get('promo_code') : NULL,
                        'promo_discount' => Session::get('discount') ? Session::get('discount') : NULL,
                    ]);

                } catch(\Exception $ex) {

                    //create booking without calendar event id
                    $booking = Booking::create([
                        'user_id' => auth()->user()->id,
                        'package_id' => $package->id,
                        'booking_address' => Session::get('address'),
                        'booking_instructions' => Session::get('instructions'),
                        'booking_date' => Session::get('event_date'),
                        'booking_time' => Session::get('booking_slot'),
                        'status' => __('backend.processing'),
                        'staff_member_id' => Session::get('staff_member_id'),
                        'city' => Session::get('city'),
                        'state' => Session::get('state'),
                        'zip' => Session::get('zip'),
                        'group_size' => Session::get('group_size'),
                        'event_type' => Session::get('event_type'),
                        'promo_used' => Session::get('promo_code') ? Session::get('promo_code') : NULL,
                        'promo_discount' => Session::get('discount') ? Session::get('discount') : NULL,
                    ]);

                }

            }
            else
            {
                //create booking without calendar event id
                $booking = Booking::create([
                    'user_id' => auth()->user()->id,
                    'package_id' => $package->id,
                    'booking_address' => Session::get('address'),
                    'booking_instructions' => Session::get('instructions'),
                    'booking_date' => Session::get('event_date'),
                    'booking_time' => Session::get('booking_slot'),
                    'status' => __('backend.processing'),
                    'staff_member_id' => Session::get('staff_member_id'),
                    'city' => Session::get('city'),
                    'state' => Session::get('state'),
                    'zip' => Session::get('zip'),
                    'group_size' => Session::get('group_size'),
                    'event_type' => Session::get('event_type'),
                    'promo_used' => Session::get('promo_code') ? Session::get('promo_code') : NULL,
                    'promo_discount' => Session::get('discount') ? Session::get('discount') : NULL,
                ]);
            }

            $booking->invoice()->create([
                'user_id' => auth()->user()->id,
                'transaction_id' => $charge['id'],
                'amount' => $amount_to_charge,
                'payment_method' => __('app.credit_card'),
                'is_paid' => 1,
                'promo_used' => Session::get('promo_code') ? Session::get('promo_code') : NULL,
                'promo_discount' => Session::get('discount') ? Session::get('discount') : NULL,
            ]);

            //attach all selected addons to addon_booking
            foreach ($session_addons as $session_addon)
            {
                Addon::find($session_addon->addon_id)->bookings()->attach($booking);
            }

            //delete all session addons
            DB::table('session_addons')->where('session_email','=',auth()->user()->email)->delete();

            //update promo code if used and remove session values
            if(Session::get('promo_code'))
            {
                $coupon = CouponCode::find(Session::get('promo_code_id'));
                $coupon->update([
                    'used' => $coupon->used + 1
                ]);

                Session::forget('promo_code_id');
                Session::forget('promo_code');
                Session::forget('discount');
            }

            //send booking received email
            $admin = Role::find(1)->users()->get();

            try {

                Mail::to(auth()->user())->send(new BookingReceived($booking , auth()->user()));
                Mail::to(auth()->user())->send(new BookingInvoice($booking));

                foreach($admin as $recipient)
                {
                    Mail::to($recipient)->send(new AdminBookingNotice($booking , $recipient));
                }

                return redirect()->route('thankYou');

            } catch(\Exception $ex) {

                return redirect()->route('thankYou');

            }
        }

        return redirect()->route('paymentFailed');

    }
}
