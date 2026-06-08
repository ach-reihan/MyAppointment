<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController 
{
    public function __construct(
        protected AuthService $authService
    ) {}

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
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = strtolower(trim($request->input('login_id')));
        $password = $request->input('password'); 

        $field = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $loginId, 'password' => $password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            } elseif ($user->role === 'doctor') {
                return redirect()->route('DashboardDoctor')->with('success', 'Selamat bertugas, Dokter!');
            } elseif ($user->role === 'patient') {
                return redirect()->route('DashboardPatient')->with('success', 'Selamat datang di My Appointment!');
            }
        }

        return back()->with('error', 'Kredensial tidak valid. Akun tidak ditemukan.')->withInput($request->only('login_id'));
    }

    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'address.required' => 'Alamat domisili wajib diisi.',
        ]);

        $user = $this->authService->registerPatient($validated);

        Auth::login($user);

        return redirect()->route('DashboardPatient')->with('success', 'Pendaftaran berhasil! Selamat datang di My Appointment!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}