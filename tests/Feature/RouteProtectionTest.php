<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $doctor;
    protected User $patient;

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

        $this->doctor = User::create([
            'name' => 'Doctor User',
            'username' => 'doctor_test',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        $this->patient = User::create([
            'name' => 'Patient User',
            'username' => 'patient_test',
            'email' => 'patient@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));

        $this->get(route('DashboardDoctor'))
            ->assertRedirect(route('login'));

        $this->get(route('DashboardPatient'))
            ->assertRedirect(route('login'));
    }

    public function test_patient_cannot_access_admin_or_doctor_panels(): void
    {
        $this->actingAs($this->patient)
            ->get(route('admin.dashboard'))
            ->assertStatus(403);

        $this->actingAs($this->patient)
            ->get(route('DashboardDoctor'))
            ->assertStatus(403);
    }

    public function test_doctor_cannot_access_admin_or_patient_panels(): void
    {
        $this->actingAs($this->doctor)
            ->get(route('admin.dashboard'))
            ->assertStatus(403);

        $this->actingAs($this->doctor)
            ->get(route('DashboardPatient'))
            ->assertStatus(403);
    }

    public function test_admin_cannot_access_doctor_or_patient_panels(): void
    {
        $this->actingAs($this->admin)
            ->get(route('DashboardDoctor'))
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->get(route('DashboardPatient'))
            ->assertStatus(403);
    }

    public function test_authorized_users_can_access_their_panels(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200);

        $this->actingAs($this->doctor)
            ->get(route('DashboardDoctor'))
            ->assertStatus(200);

        $this->actingAs($this->patient)
            ->get(route('DashboardPatient'))
            ->assertStatus(200);
    }
}
