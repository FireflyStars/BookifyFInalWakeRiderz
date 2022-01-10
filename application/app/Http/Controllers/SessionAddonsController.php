<?php

namespace App\Http\Controllers;

use App\SessionAddon;
use Illuminate\Http\Request;

class SessionAddonsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Session Addon Controller
    |--------------------------------------------------------------------------
    | This controller acts as an auxiliary controller to add or remove addons
    | during booking process.
    |
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $input = $request->all();
        SessionAddon::create($input);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SessionAddon::destroy($id);
        return redirect()->route('loadFinalStep');
    }
}
