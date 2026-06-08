<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PatientAppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $patientUser;
    protected Patient $patient;
    protected User $doctorUser;
    protected Doctor $doctor;
    protected Clinic $clinic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->patientUser = User::create([
            'name' => 'Patient User',
            'username' => 'patient_test',
            'email' => 'patient@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $this->patient = Patient::create([
            'user_id' => $this->patientUser->id,
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'address' => 'Test Address',
        ]);

        $this->doctorUser = User::create([
            'name' => 'Doctor User',
            'username' => 'doctor_test',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        $this->doctor = Doctor::create([
            'user_id' => $this->doctorUser->id,
            'specialization' => 'Umum',
        ]);

        $this->clinic = Clinic::create([
            'name' => 'Poli Umum',
            'description' => 'Clinic Description',
            'status' => 'AKTIF',
        ]);

        // Connect doctor to clinic
        $this->doctor->clinics()->attach($this->clinic->id);
    }

    public function test_patient_can_create_appointment_with_selected_doctor(): void
    {
        $payload = [
            'poliklinik' => $this->clinic->id,
            'dokter' => $this->doctor->id,
            'tanggal' => Carbon::now()->addDay()->format('Y-m-d'),
            'waktu' => '10:00',
            'keluhan' => 'Sakit perut selama 2 hari',
        ];

        $response = $this->actingAs($this->patientUser)
            ->post(route('FormAppointment.store'), $payload);

        $response->assertRedirect(route('patient.dashboard'));

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'clinic_id' => $this->clinic->id,
            'complaint' => 'Sakit perut selama 2 hari',
        ]);
    }

    public function test_patient_cannot_create_appointment_with_unrelated_doctor(): void
    {
        // Create another doctor not attached to $this->clinic
        $otherDoctorUser = User::create([
            'name' => 'Other Doctor',
            'username' => 'doctor_other',
            'email' => 'other_doc@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        $otherDoctor = Doctor::create([
            'user_id' => $otherDoctorUser->id,
            'specialization' => 'Gigi',
        ]);

        $payload = [
            'poliklinik' => $this->clinic->id,
            'dokter' => $otherDoctor->id,
            'tanggal' => Carbon::now()->addDay()->format('Y-m-d'),
            'waktu' => '10:00',
            'keluhan' => 'Sakit perut selama 2 hari',
        ];

        $response = $this->actingAs($this->patientUser)
            ->post(route('FormAppointment.store'), $payload);

        $response->assertSessionHasErrors(['dokter']);
        $this->assertDatabaseMissing('appointments', [
            'patient_id' => $this->patient->id,
            'doctor_id' => $otherDoctor->id,
        ]);
    }
}
