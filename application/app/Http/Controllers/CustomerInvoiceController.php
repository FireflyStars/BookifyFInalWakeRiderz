<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Invoice;
use App\Package;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Customer Invoice Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing invoice views to
    | customer.
    |
    */

    /**
     *Load all invoices of a customer.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $invoices = auth()->user()->invoices()->get();
        return view('customer.invoices.index', compact('invoices'));
    }

    /**
     * Show particular invoice to customer.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        //get package and addons
        $package = Package::find($invoice->booking->package->id);
        $addons = DB::table('addon_booking')->where('booking_id', '=', $invoice->booking_id)->get();

        //calculate total
        $total = $package->price;

        //add addons price if any
        foreach($addons as $addon)
        {
            $total = $total + Addon::find($addon->addon_id)->price;
        }

        if($invoice->promo_discount)
        {
            $discount = ($invoice->promo_discount / 100) * $total;
            $total = $total - $discount;
        }

        if(config('settings.enable_gst'))
        {
            $gst_amount = round(( config('settings.gst_percentage') / 100 ) * $total, 2);
        }
        else
        {
            $gst_amount = 0;
        }

        return view('customer.invoices.view', compact('invoice','gst_amount', 'total', 'discount'));
    }
}
