<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function index()
    {
        return view('manageitem.manage');
    }

    public function show()
    {
        return view('manageuser.manage');
    }
}
