<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Google\Rpc\Context\AttributeContext\Request;

class RegisterController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('manageuser.manage',compact('users'));
    }


    public function create()
    {
        return view('manageuser.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);
        $attributes['type'] = 'staff';
        $user = User::create($attributes);

        return redirect('/dashboard');
    }

    public function edit($id){
        $user = User::find ($id);
        return view('manageuser.edit', compact('user'));
    }
  
    // public function update(Request $request, $id){
    //     $user = User::find ($id);
    //     $user->udpate($request);
    //     return redirect()->route('')
    // }
}
