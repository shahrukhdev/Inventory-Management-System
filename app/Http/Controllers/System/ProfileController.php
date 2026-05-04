<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function list()
    {
        return view('admin.profile.list');
    }

    public function editprofile($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'password' => 'required_with:confirm_password|max:30',
                'confirm_password' => 'required_with:password|same:password'
            ],[
                'confirm_password.same'=>'New password and confirm password must match'
            ]);

            if(!$validator->passes() ){

                return redirect()->back()->withErrors($validator);

            }else{

                $user = Auth::user();

                $user->name = $request->name;
                if($request->password) {
                    $user->password = Hash::make($request->password);
                }

                if($request->hasFile('image')) {
                    $file = $request->file('image');
                    $path = '/storage/' . $file->store('profile_images', 'public');

                    if(Storage::disk('public')->exists(str_replace('storage', '', Auth::user()->image))){
                        Storage::disk('public')->delete(str_replace('storage', '', Auth::user()->image));
                    }

                    $user->image = $path;
                }
                $user->save();

                return redirect()->back()->with('success', 'Profile Successfully Updated');
            }

        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());
        }
    }
}
