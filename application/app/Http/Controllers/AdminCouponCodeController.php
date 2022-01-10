<?php

namespace App\Http\Controllers;

use App\Category;
use App\CouponCode;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Imports\CouponCodeImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class AdminCouponCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $coupons = CouponCode::all();
        return view('coupon_codes.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('coupon_codes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponRequest $request
     * @return Response
     */
    public function store(CouponRequest $request)
    {
        $input = $request->except('category_id');

        //create coupon
        $coupon = CouponCode::create($input);

        //attach all selected categories
        if (isset($request->category_id))
        {
            foreach ($request->category_id as $category_id)
            {
                $coupon->categories()->attach($category_id);
            }
        }

        Session::flash('coupon_code_created', __('backend.coupon_created'));
        return redirect()->route('coupon-codes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $coupon = CouponCode::find($id);

        return view('coupon_codes.edit', compact('coupon', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CouponUpdateRequest $request, $id)
    {
        $input = $request->except('category_id');
        $coupon = CouponCode::find($id);

        $coupon->update($input);

        //detach all old categories
        $coupon->categories()->detach();

        //attach all selected categories
        if (isset($request->category_id))
        {

            //attach new categories
            foreach ($request->category_id as $category_id)
            {
                $coupon->categories()->attach($category_id);
            }
        }

        //set session message and redirect back to coupon-codes.index
        Session::flash('coupon_code_updated', __('backend.coupon_code_updated'));
        return redirect()->route('coupon-codes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $coupon = CouponCode::find($id);

        //delete coupon
        CouponCode::destroy($coupon->id);

        //set session message and redirect back to coupon-codes.index
        Session::flash('coupon_code_deleted', __('backend.coupon_deleted'));
        return redirect()->route('coupon-codes.index');
    }

    /**
     * Check if a category is selected for a coupon.
     *
     * @param  int $category_id
     * @param  int $coupon_id
     * @return boolean
     */
    public function is_discounted($category_id, $coupon_id)
    {
        $categories = CouponCode::find($coupon_id)->categories()->get();
        $status = false;

        foreach ($categories as $category)
        {
            if($category_id == $category->id)
            {
                $status = true;
                break;
            }
        }

        return $status;
    }

    public function import(Request $request)
    {
        if($sheet = $request->file('file'))
        {
            //check extension
            if($sheet->getClientOriginalExtension() == "xlsx" || $sheet->getClientOriginalExtension() == "xls" || $sheet->getClientOriginalExtension() == "csv")
            {
                Excel::import(new CouponCodeImport(), $sheet);
                Session::flash('import_successful', __('backend.import_successful'));
                return redirect()->route('coupon-codes.index');
            }
            else
            {
                Session::flash('invalid_format', __('backend.invalid_format_selected'));
                return redirect()->back();
            }
        }
    }
}
