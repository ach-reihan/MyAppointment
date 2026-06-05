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
        // Mengirimkan mock data jika nanti diperlukan, saat ini langsung return view
        return view('public.landing');
    }
}