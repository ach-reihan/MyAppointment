<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Clinic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterDataService
{
    /**
     * Helper to parse Indonesian date strings (e.g. "12 Mei 1985" or "1985-05-12") to standard Y-m-d format.
     */
    private function parseIndonesianDate($dateStr): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
            return $dateStr;
        }

        $months = [
            'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
            'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
            'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
            'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December',
            'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
            'Jun' => 'Jun', 'Jul' => 'Jul', 'Agt' => 'Aug', 'Ags' => 'Aug',
            'Sep' => 'Sep', 'Okt' => 'Oct', 'Nov' => 'Nov', 'Des' => 'Dec'
        ];

        $normalized = str_replace(array_keys($months), array_values($months), $dateStr);

        try {
            return Carbon::parse($normalized)->format('Y-m-d');
        } catch (\Exception $e) {
            return now()->format('Y-m-d');
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                                QUERY METHODS                               */
    /* -------------------------------------------------------------------------- */

    public function getUsers(): array
    {
        return User::orderBy('created_at', 'desc')->get()->map(function ($user) {
            $roleLabel = match($user->role) {
                'admin' => 'Admin',
                'doctor' => 'Dokter',
                'patient' => 'Pasien',
                default => ucfirst($user->role)
            };

            return [
                'id'         => $user->id,
                'username'   => $user->username,
                'role'       => $roleLabel,
                'created_at' => $user->created_at->translatedFormat('d M Y, H:i'),
            ];
        })->toArray();
    }

    public function getDoctors(): array
    {
        return Doctor::with(['user', 'clinics'])->get()->map(function ($doctor) {
            return [
                'id'           => $doctor->id,
                'nama'         => $doctor->user->name ?? 'Dokter Anonim',
                'spesialisasi' => $doctor->specialization,
                'poli'         => $doctor->clinics->pluck('name')->toArray(),
            ];
        })->toArray();
    }

    public function getPatients(): array
    {
        return Patient::with('user')->get()->map(function ($patient) {
            $dob = $patient->date_of_birth 
                ? Carbon::parse($patient->date_of_birth)->translatedFormat('d M Y') 
                : '-';

            return [
                'id'         => $patient->id,
                'nama'       => $patient->user->name ?? 'Pasien Anonim',
                'no_telepon' => $patient->phone_number,
                'tgl_lahir'  => $dob,
                'alamat'     => $patient->address,
            ];
        })->toArray();
    }

    public function getPolyclinics(): array
    {
        $borderColors = ['border-blue-600', 'border-slate-800', 'border-emerald-600', 'border-indigo-600', 'border-purple-600'];

        return Clinic::withCount('doctors')->get()->map(function ($clinic, $index) use ($borderColors) {
            $borderColor = $borderColors[$index % count($borderColors)];
            $icon = str_contains(strtolower($clinic->name), 'umum') ? 'umum' : 'anak';

            return [
                'id'            => $clinic->id,
                'nama'          => $clinic->name,
                'deskripsi'     => $clinic->description,
                'jumlah_dokter' => $clinic->doctors_count,
                'status'        => $clinic->status ?? 'AKTIF',
                'icon'          => $icon,
                'border_color'  => $borderColor
            ];
        })->toArray();
    }

    /* -------------------------------------------------------------------------- */
    /*                              MUTATION METHODS                              */
    /* -------------------------------------------------------------------------- */

    // Users CRUD
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $roleMap = ['Admin' => 'admin', 'Dokter' => 'doctor', 'Pasien' => 'patient'];
            $role = $roleMap[$data['role']] ?? 'patient';

            $user = User::create([
                'name'     => ucfirst($data['username']),
                'username' => $data['username'],
                'email'    => $data['username'] . '@hospital.com',
                'password' => Hash::make($data['password']),
                'role'     => $role,
            ]);

            if ($role === 'doctor') {
                Doctor::create([
                    'user_id'        => $user->id,
                    'specialization' => 'Umum',
                ]);
            } elseif ($role === 'patient') {
                Patient::create([
                    'user_id'       => $user->id,
                    'phone_number'  => '-',
                    'date_of_birth' => '2000-01-01',
                    'address'       => '-',
                ]);
            }

            return $user;
        });
    }

    public function updateUser($id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);
            
            $roleMap = ['Admin' => 'admin', 'Dokter' => 'doctor', 'Pasien' => 'patient'];
            $role = $roleMap[$data['role']] ?? $user->role;

            $updateData = [
                'role' => $role,
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            if ($role === 'doctor') {
                if (!Doctor::where('user_id', $user->id)->exists()) {
                    Doctor::create([
                        'user_id'        => $user->id,
                        'specialization' => 'Umum',
                    ]);
                }
                Patient::where('user_id', $user->id)->delete();
            } elseif ($role === 'patient') {
                if (!Patient::where('user_id', $user->id)->exists()) {
                    Patient::create([
                        'user_id'       => $user->id,
                        'phone_number'  => '-',
                        'date_of_birth' => '2000-01-01',
                        'address'       => '-',
                    ]);
                }
                Doctor::where('user_id', $user->id)->delete();
            } else {
                Doctor::where('user_id', $user->id)->delete();
                Patient::where('user_id', $user->id)->delete();
            }

            return $user;
        });
    }

    public function deleteUser($id): bool
    {
        return User::findOrFail($id)->delete();
    }

    // Polyclinics CRUD
    public function createPolyclinic(array $data): Clinic
    {
        return Clinic::create([
            'name'        => $data['name'],
            'description' => $data['description'],
            'status'      => $data['status'] ?? 'AKTIF',
        ]);
    }

    public function updatePolyclinic($id, array $data): Clinic
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->update([
            'name'        => $data['name'],
            'description' => $data['description'],
            'status'      => $data['status'] ?? 'AKTIF',
        ]);
        return $clinic;
    }

    public function deletePolyclinic($id): bool
    {
        return Clinic::findOrFail($id)->delete();
    }

    // Doctors CRUD
    public function createDoctor(array $data): Doctor
    {
        return DB::transaction(function () use ($data) {
            $baseUsername = Str::slug($data['name'], '_');
            $username = $baseUsername;

            $count = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $count;
                $count++;
            }

            $user = User::create([
                'name'     => $data['name'],
                'username' => $username,
                'email'    => $username . '@hospital.com',
                'password' => Hash::make('password123'),
                'role'     => 'doctor',
            ]);

            $doctor = Doctor::create([
                'user_id'        => $user->id,
                'specialization' => $data['specialization'],
            ]);

            if (!empty($data['clinics'])) {
                $clinicIds = Clinic::whereIn('name', $data['clinics'])->pluck('id');
                $doctor->clinics()->sync($clinicIds);
            }

            return $doctor;
        });
    }

    public function updateDoctor($id, array $data): Doctor
    {
        return DB::transaction(function () use ($id, $data) {
            $doctor = Doctor::findOrFail($id);
            
            $doctor->update([
                'specialization' => $data['specialization'],
            ]);

            if ($doctor->user) {
                $doctor->user->update([
                    'name' => $data['name'],
                ]);
            }

            if (isset($data['clinics'])) {
                $clinicIds = Clinic::whereIn('name', $data['clinics'])->pluck('id');
                $doctor->clinics()->sync($clinicIds);
            }

            return $doctor;
        });
    }

    public function deleteDoctor($id): bool
    {
        $doctor = Doctor::findOrFail($id);
        if ($doctor->user) {
            return $doctor->user->delete(); // Cascades in DB to delete Doctor profile
        }
        return $doctor->delete();
    }

    // Patients CRUD
    public function createPatient(array $data): Patient
    {
        return DB::transaction(function () use ($data) {
            $baseUsername = Str::slug($data['name'], '_');
            $username = $baseUsername;

            $count = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $count;
                $count++;
            }

            $user = User::create([
                'name'     => $data['name'],
                'username' => $username,
                'email'    => $username . '@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'patient',
            ]);

            return Patient::create([
                'user_id'       => $user->id,
                'phone_number'  => $data['phone_number'],
                'date_of_birth' => $this->parseIndonesianDate($data['date_of_birth']),
                'address'       => $data['address'],
            ]);
        });
    }

    public function updatePatient($id, array $data): Patient
    {
        return DB::transaction(function () use ($id, $data) {
            $patient = Patient::findOrFail($id);

            $patient->update([
                'phone_number'  => $data['phone_number'],
                'date_of_birth' => $this->parseIndonesianDate($data['date_of_birth']),
                'address'       => $data['address'],
            ]);

            if ($patient->user) {
                $patient->user->update([
                    'name' => $data['name'],
                ]);
            }

            return $patient;
        });
    }

    public function deletePatient($id): bool
    {
        $patient = Patient::findOrFail($id);
        if ($patient->user) {
            return $patient->user->delete(); // Cascades in DB to delete Patient profile
        }
        return $patient->delete();
    }
}