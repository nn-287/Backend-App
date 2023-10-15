<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\VerifyToken;
use App\Mail\WelcomeMail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'second_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the input is a valid email or a valid phone number
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !is_numeric($value)) {
                        $fail('The ' . $attribute . ' field must be a valid email address or phone number.');
                    }
                },
                'max:255',
                'unique:' . User::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name'=>$request->first_name,
            'second_name'=>$request->second_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'type' => $request->input('is_admin') ? 1 : 0, // 1 for admin, 0 for user
            
        ]);

        event(new Registered($user));


         // Generate a random verification token
         $validatetoken = rand(1000, 9999);

         // Create a new VerifyToken entry and save it
         $get_token = new VerifyToken();
         $get_token->token = $validatetoken;
         $get_token->email = $user->email; // Use $user->email instead of $data['email']
         $get_token->save();
 
         // Get user data
         $get_user_email = $user->email;
         $get_user_F_name = $user->first_name;
         $get_user_S_name = $user->second_name;
 
         // Send the welcome email with the verification token
         Mail::to($user->email)->send(new WelcomeMail($get_user_email, $validatetoken, $get_user_F_name, $get_user_S_name));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }




    
    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email')))
        {
            return ['phone_number'=>$request->get('email'),'password'=>$request->get('password')];

        }

        return $request->only($this->username(),'password');
    }



    
}
