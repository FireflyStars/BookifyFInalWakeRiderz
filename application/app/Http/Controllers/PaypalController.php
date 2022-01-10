<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\CouponCode;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Package;
use App\Role;
use App\SessionAddon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\PaymentExecution;
use Spatie\GoogleCalendar\Event;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class PaypalController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Paypal Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for calculating booking charges,
    | taking user to paypal, get cURL response from paypal. In case of
    | payment success, this controller will create a booking with all
    | details. In case of payment failure it will show a payment failed error.
    |
    */


    /**
     * Setup PayPal API config.
     */
    private $_api_context;

    /**
     * INIT Paypal config.
     */
    public function __construct()
    {
        $settings = array(
            'mode' => config('settings.paypal_sandbox_enabled') ? 'sandbox' : 'live',
            'http.ConnectionTimeOut' => 1000,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'FINE'
        );

        $this->_api_context = new ApiContext(new OAuthTokenCredential(config('settings.paypal_client_id'),
            config('settings.paypal_client_secret')));
        $this->_api_context->setConfig($settings);
    }

    /**
     * Calculate charges and initiate payment
     * @return mixed
     */

    public function payWithPaypal()
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

        if(config('settings.paypal_processing_fee'))
        {
            $amount_to_charge = $amount_to_charge + config('settings.paypal_processing_fee');
        }

        //create Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        //create billable items
        $item = new Item();
        $item->setName(config('settings.business_name')." Booking")
        ->setCurrency(config('settings.default_currency'))
            ->setQuantity(1)
            ->setPrice($amount_to_charge);

        $item_list = new ItemList();
        $item_list->setItems(array($item));

        //set amount to be charged
        $amount = new Amount();
        $amount->setCurrency(config('settings.default_currency'))
            ->setTotal($amount_to_charge);

        //create transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list);

        //set redirect URLs
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paymentSuccessful'))
        ->setCancelUrl(route('paymentFailed'));

        //set payment
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        $payment->create($this->_api_context);

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        try {
            //save payment ID and redirect to paypal for payment
            Session::put('paypal_payment_id', $payment->getId());
            if(isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }
        } catch (\Exception $ex) {
            //set error and redirect to finalize booking
            Session::flash('paypal_error', $ex->getMessage());
            return redirect()->route('loadFinalStep');
        }

        //set error and redirect to finalize booking
        Session::flash('paypal_error', __('backend.paypal_error'));
        return redirect()->route('loadFinalStep');

    }

    /**
     * If payment is successful, save booking, send emails and show success.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function paymentSuccessful(Request $request)
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

        if(config('settings.paypal_processing_fee'))
        {
            $amount_to_charge = $amount_to_charge + config('settings.paypal_processing_fee');
        }

        //get payment ID saved already
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        //check if customer completed payment
        if (empty(Input::get('PayerID')) || empty(Input::get('token')))
        {
            //payment not completed, redirect to payment failed
            return redirect()->route('paymentFailed');
        }

        //payment is successful, lets get payment data
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        if($result->getState() == 'approved')
        {

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

                    //save booking with calendar event id
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

                    //save booking without calendar event id
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
                //save booking without calendar event id
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

            //save invoice
            $booking->invoice()->create([
                'user_id' => auth()->user()->id,
                'transaction_id' => $payment_id,
                'amount' => $amount_to_charge,
                'payment_method' => __('app.paypal'),
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
            DB::table('session_addons')->where('session_email','=', auth()->user()->email)->delete();

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

                Mail::to(auth()->user())->send(new BookingReceived($booking, auth()->user()));
                Mail::to(auth()->user())->send(new BookingInvoice($booking));

                foreach($admin as $recipient)
                {
                    Mail::to($recipient)->send(new AdminBookingNotice($booking, $recipient));
                }

                return redirect()->route('thankYou');

            } catch(\Exception $ex) {

                return redirect()->route('thankYou');

            }

        }

        //error, just redirect
        return redirect()->route('paymentFailed');

    }

    /**
     * Payment failed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentFailed()
    {
        return redirect()->route('paymentFailed');
    }
}
