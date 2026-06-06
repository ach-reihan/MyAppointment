<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController 
{
    public function index()
    {
        return view('public.landing');
    }
}