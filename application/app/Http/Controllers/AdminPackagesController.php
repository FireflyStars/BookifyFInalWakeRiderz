<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PackageRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Package;
use App\Photo;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class AdminPackagesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Packages Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking package views to
    | admin, to show all packages, provide ability to edit and delete
    | specific package.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PackageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.package_thumbnail_width'),config('settings.package_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to package $input
            $input['photo_id'] = $photo->id;
        }

        Package::create($input);

        //set session message and redirect back to packages.index
        Session::flash('package_created', __('backend.package_created'));
        return redirect()->route('packages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $categories = Category::all();
        return view('packages.edit', compact('package', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PackageUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackageUpdateRequest $request, $id)
    {
        $input = $request->all();

        //find package
        $package = Package::findOrFail($id);

        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.package_thumbnail_width'),config('settings.package_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;

            //unlink old photo if set
            if($package->photo != NULL)
            {
                unlink(public_path().$package->photo->file);
            }

            //delete data from photos table
            Photo::destroy($package->photo_id);
        }
        //update data into packages table
        $package->update($input);

        //set session message and redirect back packages.index
        Session::flash('package_updated', __('backend.package_updated'));
        return redirect()->route('packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific package
        $package = Package::findOrFail($id);

        if($package->photo)
        {
            //unlink image
            unlink(public_path().$package->photo->file);

            //delete from photo table
            Photo::destroy($package->photo_id);
        }

        //delete package
        Package::destroy($package->id);

        //set session message and redirect back to packages.index
        Session::flash('package_deleted', __('backend.package_deleted'));
        return redirect()->route('packages.index');
    }
}
