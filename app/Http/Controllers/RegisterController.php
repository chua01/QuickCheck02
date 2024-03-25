<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        $users = User::all();
        // dd($users);
        return view('manageuser.manage',compact('users'));
    }

    // public function create()
    // {
    //     return view('auth.register');
    // }
    
    public function create()
    {
        return view('manageuser.create');
    }

    public function store()
    {
        // dd('sdfsdf');
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            // 'terms' => 'required'
        ]);
        // dd($attributes);
        $attributes['type'] = 'staff';
        $user = User::create($attributes);
        // auth()->login($user);

        return redirect('/dashboard');
    }
}
