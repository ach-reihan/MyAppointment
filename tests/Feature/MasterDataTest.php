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
}
