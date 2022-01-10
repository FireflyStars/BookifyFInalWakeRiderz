<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Invoice;
use App\Package;
use Illuminate\Support\Facades\DB;

class AdminInvoicesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Invoices Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for providing invoices views to admin.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        return view('invoices.view', compact('invoice','gst_amount', 'total', 'discount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);

        $invoice->update([
            'is_paid' => 1
        ]);

        return redirect()->route('invoices.index');
    }

}
