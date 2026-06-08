<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataTest extends TestCase
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

    public function test_admin_cannot_delete_themselves(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.master-data.users.destroy', ['id' => $this->admin->id]));

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Anda tidak dapat menghapus akun Anda sendiri.',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_delete_other_users(): void
    {
        $otherUser = User::create([
            'name' => 'Other User',
            'username' => 'other_test',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.master-data.users.destroy', ['id' => $otherUser->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $otherUser->id,
        ]);
    }

    public function test_creating_doctor_user_creates_doctor_profile(): void
    {
        $payload = [
            'username' => 'new_doctor',
            'password' => 'password123',
            'role'     => 'Dokter',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.master-data.users.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user = User::where('username', 'new_doctor')->firstOrFail();
        $this->assertEquals('doctor', $user->role);

        $this->assertDatabaseHas('doctors', [
            'user_id' => $user->id,
            'specialization' => 'Umum',
        ]);
    }

    public function test_creating_patient_user_creates_patient_profile(): void
    {
        $payload = [
            'username' => 'new_patient',
            'password' => 'password123',
            'role'     => 'Pasien',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.master-data.users.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user = User::where('username', 'new_patient')->firstOrFail();
        $this->assertEquals('patient', $user->role);

        $this->assertDatabaseHas('patients', [
            'user_id' => $user->id,
            'phone_number' => '-',
            'address' => '-',
        ]);
    }

    public function test_updating_user_role_to_doctor_creates_missing_doctor_profile(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'reg_user',
            'email' => 'reg@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $payload = [
            'role' => 'Dokter',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.master-data.users.update', ['id' => $user->id]), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals('doctor', $user->role);

        $this->assertDatabaseHas('doctors', [
            'user_id' => $user->id,
            'specialization' => 'Umum',
        ]);
    }

    public function test_updating_user_role_from_doctor_to_patient_deletes_doctor_profile_and_creates_patient_profile(): void
    {
        $user = User::create([
            'name' => 'Doctor User',
            'username' => 'doc_user',
            'email' => 'doc@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);
        \App\Models\Doctor::create([
            'user_id' => $user->id,
            'specialization' => 'Umum',
        ]);

        $payload = [
            'role' => 'Pasien',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.master-data.users.update', ['id' => $user->id]), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals('patient', $user->role);

        $this->assertDatabaseMissing('doctors', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('patients', [
            'user_id' => $user->id,
            'phone_number' => '-',
        ]);
    }

    public function test_updating_user_role_from_patient_to_admin_deletes_patient_profile(): void
    {
        $user = User::create([
            'name' => 'Patient User',
            'username' => 'pat_user',
            'email' => 'pat@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);
        \App\Models\Patient::create([
            'user_id' => $user->id,
            'phone_number' => '0812',
            'date_of_birth' => '1995-10-10',
            'address' => 'Some address',
        ]);

        $payload = [
            'role' => 'Admin',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.master-data.users.update', ['id' => $user->id]), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals('admin', $user->role);

        $this->assertDatabaseMissing('patients', [
            'user_id' => $user->id,
        ]);
    }
}
