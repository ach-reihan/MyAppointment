<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController 
{
    /**
     * Menangani Landing Page (Public)
     */
    public function index()
    {
        return view('public.landing');
    }
}