<?php

namespace App\Services;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register a new patient and associate a patient profile.
     */
    public function registerPatient(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'role' => 'patient',
            ]);

            Patient::create([
                'user_id' => $user->id,
                'phone_number' => $data['phone_number'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['address'],
            ]);

            return $user;
        });
    }
}
