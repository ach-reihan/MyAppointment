<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController 
{
    /**
     * Data Mocking untuk mensimulasikan tabel 'users' di database.
     * Nanti saat integrasi DB riil, ini akan diganti dengan query Eloquent:
     * User::where('email', $loginId)->orWhere('username', $loginId)->first();
     */
    protected $mockDatabase = [
        [
            'id' => 1,
            'name' => 'Dr. Sarah Wijaya',
            'username' => 'admin_sarah',
            'email' => 'admin@gmail.com',
            'password' => 'password123',
            'role' => 'admin'
        ],
        [
            'id' => 2,
            'name' => 'Dr. Budi Santoso',
            'username' => 'dr_budi',
            'email' => 'dokter@gmail.com',
            'password' => 'password123',
            'role' => 'dokter'
        ],
        [
            'id' => 3,
            'name' => 'Pasien Umum',
            'username' => 'pasien01',
            'email' => 'pasien@gmail.com',
            'password' => 'password123',
            'role' => 'pasien'
        ]
    ];

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function processLogin(Request $request)
    {
        $loginId = strtolower(trim($request->input('login_id')));
        $password = $request->input('password'); 

        $userRole = null;

        foreach ($this->mockDatabase as $user) {
            if ($user['email'] === $loginId || strtolower($user['username']) === $loginId) {
                $userRole = $user['role'];
                break;
            }
        }

        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        } elseif ($userRole === 'dokter') {
            return redirect()->route('DashboardDoctor')->with('success', 'Selamat bertugas, Dokter!');
        } elseif ($userRole === 'pasien') {
            return redirect()->route('patient.dashboard')->with('success', 'Selamat datang di My Appointment!');
        }

        return back()->with('error', 'Kredensial tidak valid. Akun tidak ditemukan.');
    }

    public function processRegister(Request $request)
    {
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk dengan akun baru Anda.');
    }

}