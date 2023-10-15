<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\PasswordReset;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }






    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'=>'required|min:2|max:100',
            'second_name'=>'required|min:2|max:100',
            'profession'=>'nullable|max:100',
            'gender'=>'nullable|max:100',
        ]);



        if($validator->fails())
        {
            return response()->json([
                'message'=>'Validation fails',
                'errors'=>$validator->errors()
               
            ],422);
           
        }


        $user = $request->user();

        $user->update([
            'first_name'=>$request->first_name,
            'second_name'=>$request->second_name,
            'profession'=>$request->profession,
            'gender'=>$request->gender,

        ]);


        return response()->json([

            'message' => 'Profile updated successfully',
            'user' => $user,
        ], 200);

    }




    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'=>'required',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password',
            
        ]);


        if($validator->fails())
        {
            return response()->json([
                'message'=>'Validation fails',
                'errors'=>$validator->errors()
               
            ],422);
           
        }

        $user = $request->user();



        if(Hash::check($request->old_password,$user->password))
        {
                $user->update([
                    'password'=>Hash::make($request->password)
                ]);

                return response()->json([
                    'message'=>'Password successfully updated',
                    
                ],200);


        }
        else
        {
            return response()->json([
                'message'=>'Old password does not match',
                
            ],400);

        }

    }


    



    
}
