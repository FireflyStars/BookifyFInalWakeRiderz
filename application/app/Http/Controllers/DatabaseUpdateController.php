<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class DatabaseUpdateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Database Update Controller
    |--------------------------------------------------------------------------
    |
    | This controller will migrate new database migration to keep database
    | up to date.
    |
    */

    /**
     * Migrate and update database.
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        Artisan::call('migrate', ['--force' => true]);
        Session::flash('database_updated', __('backend.database_updated'));
        return redirect('home');
    }
}
