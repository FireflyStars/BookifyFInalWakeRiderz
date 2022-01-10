<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Invoice;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing dashboard views to
    | admin and customer.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get data for bookings graph.
     *
     * @return array
     */
    public function get_booking_graph_data()
    {
        $chartData = Booking::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();

        $chartDataByDay = array();
        foreach($chartData as $data) {
            $chartDataByDay[$data['date']] = $data['count'];
        }

        $date = new Carbon;
        for($i = 0; $i < 7; $i++) {
            $dateString = $date->format('Y-m-d');
            if(!isset($chartDataByDay[ $dateString ]))
            {
                $chartDataByDay[ $dateString ] = 0;
            }
            $date->subDay();
        }

        ksort($chartDataByDay);

        return $chartDataByDay;
    }

    /**
     * Get data for revenue graph.
     *
     * @return array
     */
    public function get_revenue_graph_data()
    {
        $chartData = Invoice::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('SUM(amount) AS sum'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->where('is_refunded', '=', 0)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();

        $chartDataByDay = array();
        foreach($chartData as $data) {
            $chartDataByDay[$data['date']] = $data['sum'];
        }

        $date = new Carbon;
        for($i = 0; $i < 7; $i++) {
            $dateString = $date->format('Y-m-d');
            if(!isset($chartDataByDay[ $dateString ]))
            {
                $chartDataByDay[ $dateString ] = 0;
            }
            $date->subDay();
        }

        ksort($chartDataByDay);

        return $chartDataByDay;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if Auth user role is admin
        if(auth()->user()->role->id === 1)
        {
            //customer count
            $customers = Role::find(2)->users->count();

            //all booking count
            $bookings = Booking::all()->count();

            //cancelled booking count
            $bookings_cancelled = Booking::all()->where('status', '=', __('backend.cancelled'))->count();

            //find total of refunded invoices
            $total_refunded = Invoice::all()->where('is_refunded', '=', 1)->sum('amount');

            //find total of successful invoices
            $total_earning = Invoice::all()->where('is_refunded', '=', 0)->where('is_paid', '=', 1)->sum('amount');

            //find total of successful invoices
            $total_unpaid = Invoice::all()->where('is_refunded', '=', 0)->where('is_paid', '=', 0)->sum('amount');

            //get graph data
            $bookings_graph = $this->get_booking_graph_data();
            $revenue_graph = $this->get_revenue_graph_data();

            //make booking calendar data
            $bookings_c = Booking::all()->where('status', '!=', __('backend.cancelled'));
            $list_bookings = [];
            $counter_c = 0;
            foreach ($bookings_c as $booking)
            {
                $list_bookings[$counter_c]['id'] = $booking->id;
                $list_bookings[$counter_c]['title'] = $booking->package->title;
                $list_bookings[$counter_c]['color_code'] = $booking->package->category->color_code;
                $list_bookings[$counter_c]['url'] = route('bookings.show', $booking->id);

                $time = explode("-", $booking->booking_time);

                $list_bookings[$counter_c]['start_at'] = date('Y-m-d', strtotime($booking->booking_date))."T".date('H:i:s', strtotime($time[0]));
                $list_bookings[$counter_c]['end_at'] = date('Y-m-d', strtotime($booking->booking_date))."T".date('H:i:s', strtotime($time[1]));


                $counter_c++;
            }

            return view('dashboard.admin', compact('customers', 'bookings', 'bookings_cancelled', 'total_unpaid', 'total_earning', 'total_refunded', 'bookings_graph', 'revenue_graph', 'list_bookings', 'counter_c'));
        }

        //if Auth user role is customer
        else if(auth()->user()->role->id == 2)
        {
            $user = auth()->user();

            //count of users booking
            $bookings = $user->bookings()->where('status','!=', __('backend.cancelled'))->count();

            //total of successful invoices
            $total_paid = $user->invoices()->where('is_refunded','=', 0)->sum('amount');

            //total of refunded invoices
            $total_refunded = $user->invoices()->where('is_refunded','=', 1)->sum('amount');

            //cancelled bookings count
            $bookings_cancelled = $user->bookings()->where('status','=', __('backend.cancelled'))->count();

            //make booking calendar data
            $bookings_c = Booking::all()
                ->where('status', '!=', __('backend.cancelled'))
                ->where('user_id', '=', auth()->user()->id);
            $list_bookings = [];
            $counter_c = 0;
            foreach ($bookings_c as $booking)
            {
                $list_bookings[$counter_c]['id'] = $booking->id;
                $list_bookings[$counter_c]['title'] = $booking->package->title;
                $list_bookings[$counter_c]['color_code'] = $booking->package->category->color_code;
                $list_bookings[$counter_c]['url'] = route('showBooking', $booking->id);

                $time = explode("-", $booking->booking_time);

                $list_bookings[$counter_c]['start_at'] = date('Y-m-d', strtotime($booking->booking_date))."T".date('H:i:s', strtotime($time[0]));
                $list_bookings[$counter_c]['end_at'] = date('Y-m-d', strtotime($booking->booking_date))."T".date('H:i:s', strtotime($time[1]));

                $counter_c++;
            }

            return view('dashboard.customer', compact('bookings', 'total_paid',
                'bookings_cancelled', 'total_refunded', 'list_bookings', 'counter_c'));
        }
    }

}
