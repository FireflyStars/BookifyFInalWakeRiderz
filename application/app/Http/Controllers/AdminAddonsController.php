<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Category;
use App\Http\Requests\AddonsRequest;
use App\Http\Requests\AddonUpdateRequest;
use App\Photo;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class AdminAddonsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Addons Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing addons views to admin, to
    | show all addons, provide ability to edit and delete specific addons.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addons = Addon::all();
        return view('addons.index', compact('addons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('addons.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddonsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddonsRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.addon_thumbnail_width'),config('settings.addon_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to addon $input
            $input['photo_id'] = $photo->id;
        }

        Addon::create($input);

        //set session message nd redirect back to addons.index
        Session::flash('addon_created', __('backend.addon_created'));
        return redirect()->route('addons.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addon = Addon::findOrFail($id);
        $categories = Category::all();
        return view('addons.edit', compact('addon', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AddonUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddonUpdateRequest $request, $id)
    {
        $input = $request->all();

        //find addon
        $addon = Addon::findOrFail($id);

        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.addon_thumbnail_width'),config('settings.addon_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to addon $input
            $input['photo_id'] = $photo->id;

            //unlink old photo if set
            if($addon->photo != NULL)
            {
                unlink(public_path().$addon->photo->file);
            }

            //delete data from photos table
            Photo::destroy($addon->photo_id);
        }

        //update data into addons table
        $addon->update($input);

        //set session message and redirect back addons.index
        Session::flash('addon_updated', __('backend.addon_updated'));
        return redirect()->route('addons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific addon
        $addon = Addon::findOrFail($id);

        if($addon->photo)
        {
            //unlink image
            unlink(public_path().$addon->photo->file);

            //delete from photo table
            Photo::destroy($addon->photo_id);
        }

        //delete addon
        Addon::destroy($addon->id);

        //set session message and redirect back to addons.index
        Session::flash('addon_deleted', __('backend.addon_deleted'));
        return redirect()->route('addons.index');
    }
}
