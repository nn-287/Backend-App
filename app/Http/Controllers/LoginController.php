<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use AuthenticatesUsers;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     //use AuthenticatesUsers;
 
    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function login(Request $request)
    {   
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) 
        {
            if (auth()->user()->type == 1) {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('user.dashboard');
            }
        } 
        else 
        {
            return redirect()->route('login')->with('error', 'Email-Address And Password Are Wrong.');
        }
            
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
