<?php

namespace App\Http\Controllers;

use App\BookingTime;
use App\Http\Requests\SettingsRequest;
use App\Role;
use App\Settings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AdminSettingsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Settings Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing settings view to
    | admin, to show all settings, provide ability to change
    | specific settings.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::find(1);
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SettingsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingsRequest $request, $id)
    {
        $input = $request->except('business_logo_light', 'business_logo_dark', 'cover');

        //update data into settings table
        Settings::findOrFail($id)->update($input);

        //check if cover image is selected
        if($cover = $request->file('cover'))
        {
            //remove previous promo image
            unlink(public_path().'/images/promo.jpg');

            //upload new promo image
            $cover->move('images','promo.jpg');
        }

        //check if logo-light is selected
        if($logo_light = $request->file('business_logo_light'))
        {
            //remove previous light logo
            unlink(public_path().'/images/logo-light.png');

            //upload new light logo
            $logo_light->move('images','logo-light.png');
        }

        //check if logo-dark is selected
        if($logo_dark = $request->file('business_logo_dark'))
        {
            //remove previous dark logo
            unlink(public_path().'/images/logo-dark.png');

            //upload new dark logo
            $logo_dark->move('images','logo-dark.png');
        }

        //check if lang is changed
        if($request->lang != config('settings.lang'))
        {
            App::setLocale($request->lang);

            //language is changed, put new day names
            BookingTime::find(1)->update([
                'day' => __('backend.mon')
            ]);

            BookingTime::find(2)->update([
                'day' => __('backend.tue')
            ]);

            BookingTime::find(3)->update([
                'day' => __('backend.wed')
            ]);

            BookingTime::find(4)->update([
                'day' => __('backend.thu')
            ]);

            BookingTime::find(5)->update([
                'day' => __('backend.fri')
            ]);

            BookingTime::find(6)->update([
                'day' => __('backend.sat')
            ]);

            BookingTime::find(7)->update([
                'day' => __('backend.sun')
            ]);

            //put new role names
            Role::find(1)->update([
                'name' => __('backend.administrator')
            ]);

            Role::find(2)->update([
                'name' => __('backend.customer')
            ]);
        }

        //set session message and redirect back settings.index
        Session::flash('settings_saved', __('backend.settings_saved'));
        return redirect()->route('settings.index');
    }

}
