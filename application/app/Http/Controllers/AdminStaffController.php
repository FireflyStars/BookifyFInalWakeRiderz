<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Category;
use App\Http\Requests\StaffRequest;
use App\StaffMember;
use App\StaffMemberService;
use Illuminate\Support\Facades\Session;

class AdminStaffController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Staff Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing staff view to
    | admin, to show all staff members, provide ability to edit
    | or delete specific staff members.
    |
    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = StaffMember::all();
        return view('staff_members.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('staff_members.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StaffRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $input = $request->all();

        $staff_member = StaffMember::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'email' => $input['email']
        ]);

        foreach ($request->category_id as $category)
        {
            StaffMemberService::create([
                'staff_member_id' => $staff_member->id,
                'category_id' => $category
            ]);
        }

        //set session message and redirect back to staff.index
        Session::flash('staff_member_created', __('backend.staff_member_created'));
        return redirect()->route('staff.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = StaffMember::find($id);
        $services = $staff->services()->get();
        $categories = Category::all();

        return view('staff_members.edit', compact('staff', 'services', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StaffRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, $id)
    {
        $input = $request->all();
        $staff = StaffMember::find($id);

        $staff->update([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'email' => $input['email'],
        ]);

        $services = StaffMemberService::all()->where('staff_member_id', '=', $staff->id);

        foreach ($services as $service)
        {
            StaffMemberService::destroy($service->id);
        }

        foreach ($request->category_id as $category)
        {
            StaffMemberService::create([
                'staff_member_id' => $staff->id,
                'category_id' => $category
            ]);
        }

        //set session message and redirect back to staff.index
        Session::flash('staff_member_updated', __('backend.staff_member_updated'));
        return redirect()->route('staff.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = StaffMember::find($id);
        $services = $staff->services()->get();
        $bookings = $staff->bookings()->get();

        //delete services
        foreach ($services as $service)
        {
            StaffMemberService::destroy($service->id);
        }

        //delete bookings
        foreach ($bookings as $booking)
        {
            Booking::destroy($booking->id);
        }

        StaffMember::destroy($staff->id);

        //set session message and redirect back to staff.index
        Session::flash('staff_member_deleted', __('backend.staff_member_deleted'));
        return redirect()->route('staff.index');
    }

    /**
     * Check if a service is provided by staff.
     *
     * @param $category_id
     * @param $staff_id
     * @return bool
     */
    public function provides($category_id,$staff_id)
    {
        $services = StaffMemberService::all()->where('staff_member_id', '=', $staff_id);
        foreach ($services as $service)
        {
            if($service->category_id == $category_id)
            {
                return true;
                break;
            }
        }

        return false;
    }

    /**
     * Return a list of services provided by staff memeber.
     *
     * @param $id
     * @return StaffMemberService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list_services($id)
    {
        $services = StaffMemberService::all()->where('staff_member_id', '=', $id);
        return $services;
    }
}
