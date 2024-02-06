<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.register_form');
    }

    public function store()
    {
        //create the user
        $attributes = request()->validate([
            'name'=>'required|max:255',
            'username'=>['required','max:255','min:5', Rule::unique('users', 'username')],
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|min:7|max:255'
        ]);

        $user = User::create($attributes);

        auth()->login($user);

        session()->flash('success','Your account has been created.');

        return redirect('/')->with('success','Your account has been created.');
    }
}
