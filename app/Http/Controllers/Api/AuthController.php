<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 

class AuthController extends Controller
{

    public function register(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'first_name'=>'required|min:2|max:100',
            'second_name'=>'required|min:2|max:100',
            //'email'=>'required|email|unique:users',
            //'phone_number' => 'required|numeric',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password',
        ]);



        $validator->sometimes('email', ['required', 'email', 'unique:users'], function ($input) {
            return empty($input->phone_number);
        });
    
        $validator->sometimes('phone_number', ['required', 'numeric', 'unique:users'], function ($input) {
            return empty($input->email);
        });



        if($validator->fails())
        {
            return response()->json([
                'message'=>'Validation fails',
                'errors'=>$validator->errors()
               
            ],422);
           
        }


        $userData = [
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'password' => Hash::make($request->password),
        ];


        if ($request->email) {
            $userData['email'] = $request->email;
        }
    
        if ($request->phone_number) {
            $userData['phone_number'] = $request->phone_number;
        }
            // If neither 'email' nor 'phone_number' is provided, it's okay; continue with registration
            $user = User::create($userData);


        /*
        $user = User::create([
            'first_name'=>$request->first_name,
            'second_name'=>$request->second_name,
            //'email'=>$request->email,
            //'phone_number' => $request['phone_number'],
            'password'=>Hash::make($request->password)
            
        ]);
        */



        return response()->json([
            'message'=>'Successful registration',
            'errors'=>$user
           
        ],200);





        



    }









    public function login(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password'=>'required',
        ]);



        $validator->sometimes('login', ['email'], function ($input) {
            return filter_var($input->login, FILTER_VALIDATE_EMAIL);
        });

        
        $validator->sometimes('login', ['regex:/^[0-9]{10}$/'], function ($input) {
            return preg_match('/^[0-9]{10}$/', $input->login);
        });


        


        if($validator->fails())
        {
            return response()->json([
                'message'=>'Validation fails',
                'errors'=>$validator->errors()
            ],422);
        }


        //$user = User::where('email',$request->email)->first();

        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->login)
                  ->orWhere('phone_number', $request->login);
        })->first();



        if($user)
        {
            if(Hash::check($request->password,$user->password))
            {
                $token = $user->createToken('auth-token')->plainTextToken;

                return response()->json([
                    'message'=>'Login successful',
                    'token'=>$token,
                    'data'=>$user
                    
                ],200);


            }
            else
            {
                return response()->json([
                    'message'=>'Incorrect credentials',
                    
                ],400);

            }

        }
        else
        {
            return response()->json([
                'message'=>'Incorrect credentials',
                
            ],400);
        }
    }







    public function getusers()
    {
        $users = User::get();
        return UserResource::collection($users);
    }





    public function forget_password(Request $request)
    {
        try
        {
            $user = User::where('email',$request->email)->get();

            if(count($user) > 0)
            {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'password reset';
                $data['body'] = "Please click on the below link to reset your password";


                Mail::raw($data['body'], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                


                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email'=>$request->email],
                    [
                        'email'=>$request->email,
                        'token'=>$token,
                        'created_at'=>$datetime,

                    ]
                    );



                    return response()->json([
                        'success'=>true, 'msg'=>'Please check you mail'
                        
                    ]);
    


            }
            else
            {
                return response()->json([
                    'success'=>false, 'msg'=>'User not found'
                    
                ]);

            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success'=>false, 'msg'=>$e->getMessage()
                
            ]);


        }
    }








    
}
