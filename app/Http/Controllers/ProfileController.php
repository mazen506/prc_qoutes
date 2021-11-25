<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index(){
            $currencies = Currency::all();
            $user = Auth::user();
            return view('profile', compact('currencies','user'));
    }

    public function setLogo(Request $request){
 
        try {
        $validator = $request->validate([
          //'item_name' => 'required'
            'file-profile-logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Only allow .jpg, .bmp and .png file types.
        ]);
 

           if ($file=$request->file('file-profile-logo')){
                 $image_name = $file->hashName();
                 $file->store('item_images','public');
                 //Remove previous image
                 if (Storage::exists('public/item_images/' . Auth::user()->logo))
                    Storage::delete('public/item_images/' . Auth::user()->logo);
                 return response()->json(['image'=> $image_name]);
            }
            else
                 return response('No such file!',400);
       }
       catch (\Illuminate\Validation\ValidationException $e)
       {
         $errors = $e->errors();
         return response()->json($errors);
       }

     }

    public function store(Request $request)
    {
            
    }

    public function update(Request $request)
    {
        try {

            $logo_img = $request->input('img-profile-logo-name');

            $validator = $request->validate([
                //'item_name' => 'required'
               'title_' . app()->getlocale() => 'required',
               'currency_id' => 'required',
               'file-profile-logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Only allow .jpg, .bmp and .png file types.
               'phone' => 'required',
               'description_' .  app()->getlocale() => 'required',
               'address_' . app()->getlocale() => 'required'
              ]);

              $new_logo;
              if ($file=$request->file('file-profile-logo')){
                $new_logo = $file->hashName();
                $file->store('item_images','public');
              }
              else if (empty(Auth::user()->logo))
                return response('No Logo!!',500);

            $user = Auth::user();
            $previous_logo = $user->logo;
            $user['title_' . app()->getLocale()] = $request->input('title_' . app()->getLocale());
            $user->currency_id = $request->input('currency_id');
            $user->phone = $request->input('phone');
            $user['description_' . app()->getLocale()] = $request->input('description_' . app()->getLocale());
            $user['address_' . app()->getLocale()] = $request->input('address_' . app()->getLocale());

            if (!empty($new_logo))
                $user->logo = $new_logo;
            $user->save();

            //Delete previous logo
            if (!empty($new_logo) && Storage::exists('public/item_images/' . $previous_logo))
                Storage::delete('public/item_images/' . $previous_logo);
            return response(200);
        }
        catch (\Illuminate\Validation\ValidationException $e)
        {
          $errors = $e->errors();
          return response()->json($errors,500);
        }
        
        //$profile->save()
    }

    
}
