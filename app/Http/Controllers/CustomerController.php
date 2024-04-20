<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(){
        return view('managecustomer.manage');
    }
   
    public function create(){
        return view('managecustomer.create');
    }
}
