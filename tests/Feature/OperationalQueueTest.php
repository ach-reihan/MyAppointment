<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperationalQueueTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin_test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_operational_queue(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.operational.queue'));
        $response->assertStatus(200);
        $response->assertViewHas('queues');
    }

    public function test_admin_can_create_new_appointment_in_queue(): void
    {
        $patientUser = User::create([
            'name' => 'Patient User',
            'username' => 'patient_test',
            'email' => 'patient@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'address' => 'Test Address',
        ]);

        $doctorUser = User::create([
            'name' => 'Doctor User',
            'username' => 'doctor_test',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'Umum',
        ]);

        $clinic = Clinic::create([
            'name' => 'Poli Umum',
            'description' => 'Clinic Description',
        ]);

        $payload = [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'appointment_datetime' => '2026-06-07 10:00:00',
            'status' => 'pending',
            'complaint' => 'Sakit kepala',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.operational.queue.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'complaint' => 'Sakit kepala',
        ]);
    }

    public function test_admin_can_mark_appointment_as_completed(): void
    {
        $patientUser = User::create([
            'name' => 'Patient User',
            'username' => 'patient_test',
            'email' => 'patient@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'address' => 'Test Address',
        ]);

        $doctorUser = User::create([
            'name' => 'Doctor User',
            'username' => 'doctor_test',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'Umum',
        ]);

        $clinic = Clinic::create([
            'name' => 'Poli Umum',
            'description' => 'Clinic Description',
        ]);

        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'appointment_datetime' => '2026-06-07 10:00:00',
            'status' => 'pending',
            'complaint' => 'Sakit kepala',
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.operational.queue.done', ['id' => $appt->id]));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('appointments', [
            'id' => $appt->id,
            'status' => 'completed',
        ]);
    }

    public function test_admin_can_delete_appointment_from_queue(): void
    {
        $patientUser = User::create([
            'name' => 'Patient User',
            'username' => 'patient_test',
            'email' => 'patient@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'address' => 'Test Address',
        ]);

        $doctorUser = User::create([
            'name' => 'Doctor User',
            'username' => 'doctor_test',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'Umum',
        ]);

        $clinic = Clinic::create([
            'name' => 'Poli Umum',
            'description' => 'Clinic Description',
        ]);

        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $clinic->id,
            'appointment_datetime' => '2026-06-07 10:00:00',
            'status' => 'pending',
            'complaint' => 'Sakit kepala',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.operational.queue.destroy', ['id' => $appt->id]));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('appointments', [
            'id' => $appt->id,
        ]);
    }
}
