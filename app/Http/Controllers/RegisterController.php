<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// use Google\Rpc\Context\AttributeContext\Request;

class RegisterController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == 'admin'){
            $users = User::all();
            return view('manageuser.manage',compact('users'));
        }
         return redirect()->intended('dashboard');
    }


    public function create()
    {
        if(Auth::user()->type == 'admin'){
            return view('manageuser.create');
        }
        return redirect()->intended('dashboard');
    }

    public function store()
    {
        if(Auth::user()->type == 'admin'){
            $attributes = request()->validate([
                'username' => 'required|max:255|min:2',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:5|max:255',
            ]);
            $attributes['type'] = 'staff';
            User::create($attributes);
    
            return redirect('/dashboard');
        }
        return redirect()->intended('dashboard');
    }

    public function edit($id){
        if(Auth::user()->type == 'admin'){
            $user = User::find ($id);
            return view('manageuser.edit', compact('user'));
        }
        return redirect()->intended('dashboard');
    }
  
    public function update($id){
        
        if(Auth::user()->type == 'admin'){
            $request = request();
            $user = User::find ($id);
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return redirect()->route('user');
        }
        return redirect()->intended('dashboard');
    }

    public function destroy($id){
        if(Auth::user()->type == 'admin'){
            $user = User::find($id);
            $user->delete();
            return redirect()->route('user');
        }
        return redirect()->intended('dashboard');
    }
}
