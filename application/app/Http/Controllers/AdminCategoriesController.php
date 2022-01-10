<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Photo;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class AdminCategoriesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Categories Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking categories views
    | to admin, to show all categories, provide ability to edit and delete
    | specific category.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.category_thumbnail_width'),config('settings.category_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;
        }

        Category::create($input);

        //set session message and redirect back to categories.index
        Session::flash('category_created', __('backend.category_created'));
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $input = $request->all();

        //find category
        $category = Category::findOrFail($id);

        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            Image::configure(array('driver' => config('image.driver')));
            Image::make($image)->fit(config('settings.category_thumbnail_width'),config('settings.category_thumbnail_height'))->save("images/".$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;

            //unlink old photo if set
            if($category->photo != NULL)
            {
                unlink(public_path().$category->photo->file);
            }

            //delete data from photos table
            Photo::destroy($category->photo_id);
        }

        //update data into categories table
        $category->update($input);

        //set session message and redirect back categories.index
        Session::flash('category_updated', __('backend.category_updated'));
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific category
        $category = Category::findOrFail($id);

        if($category->photo)
        {
            //unlink image
            unlink(public_path().$category->photo->file);

            //delete from photo table
            Photo::destroy($category->photo_id);
        }

        //delete category
        Category::destroy($category->id);

        //set session message and redirect back to categories.index
        Session::flash('category_deleted', __('backend.category_deleted'));
        return redirect()->route('categories.index');
    }
}
