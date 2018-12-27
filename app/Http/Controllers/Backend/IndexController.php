<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return view('backend/dashboard');
        }else{
            return view('auth/login');
        }
    }
}
