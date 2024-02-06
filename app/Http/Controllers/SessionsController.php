<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create()
    {
        return view('welcome');
    }

    public function store()
    {
        //validate the request
        $attributes = request()->validate([
            'email'=> 'required|exists:users,email',
            'password' => 'required'
        ]);
        //attempt to auth and log in the user based on provided credentials
        if(auth()->attempt($attributes)){
            //redirect with flash message
            return redirect('/homepage')->with('success','Welcome back!');
        }

        //session fixation
        session()->regenerate();
        //auth failed
        return redirect('/login')->withErrors(['password' => 'Your provided credentials could not be verified.']);


    }
    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success','Goodbye!');
    }
}
