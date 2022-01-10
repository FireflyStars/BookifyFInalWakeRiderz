<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileUpdate;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class CustomerProfileController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Customer Profile Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing profile views to
    | customer and ability to update profile.
    |
    */

    /**
     * Load profile edit screen for customer.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        return view('customer.profile.index', compact('user'));
    }

    /**
     * Update customer profile.
     *
     * @param CustomerProfileUpdate $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(CustomerProfileUpdate $request, $id)
    {
        $input = $request->all();

        //find user
        $user = User::findOrFail($id);

        //check if Auth user is making request
        if(auth()->user()->id == $id)
        {
            //check if image is selected
            if($image = $request->file('photo_id'))
            {
                //give a name to image and move it to public directory
                $image_name = time().$image->getClientOriginalName();
                Image::configure(array('driver' => config('image.driver')));
                Image::make($image)->fit(100,100)->save("images/".$image_name);

                //persist data into photos table
                $photo = Photo::create(['file'=>$image_name]);

                //save photo_id to user $input
                $input['photo_id'] = $photo->id;

                //unlink old photo if set
                if($user->photo != NULL)
                {
                    unlink(public_path().$user->photo->file);
                }

                //delete data from photos table
                Photo::destroy($user->photo_id);
            }

            //update data into users table
            $user->update($input);

            //set session message and redirect back customerProfile
            Session::flash('profile_updated', __('backend.profile_updated'));
            return redirect()->route('customerProfile');
        }
        else
        {
            //show 404 page
            return view('errors.404');
        }
    }
}
