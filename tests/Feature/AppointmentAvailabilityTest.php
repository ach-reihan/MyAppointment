<?php

namespace Tests\Feature;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use App\Services\AppointmentAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AppointmentAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_booking_inside_both_clinic_and_doctor_windows(): void
    {
        $clinic = Clinic::create([
            'name' => 'Poli Umum',
            'opens_at' => '08:00:00',
            'closes_at' => '16:00:00',
            'description' => 'Test clinic',
        ]);

        $doctor = Doctor::create([
            'user_id' => User::factory()->doctor()->create()->id,
            'specialization' => 'Spesialis Umum',
        ]);

        $doctor->clinics()->attach($clinic->id, [
            'available_from' => '09:00:00',
            'available_to' => '15:00:00',
        ]);

        $service = app(AppointmentAvailabilityService::class);

        $service->assertBookable($clinic, $doctor, CarbonImmutable::parse('2026-06-05 10:00:00'));

        $this->assertTrue(true);
    }

    public function test_it_rejects_booking_outside_doctor_window(): void
    {
        $clinic = Clinic::create([
            'name' => 'Poli Umum',
            'opens_at' => '08:00:00',
            'closes_at' => '16:00:00',
            'description' => 'Test clinic',
        ]);

        $doctor = Doctor::create([
            'user_id' => User::factory()->doctor()->create()->id,
            'specialization' => 'Spesialis Umum',
        ]);

        $doctor->clinics()->attach($clinic->id, [
            'available_from' => '09:00:00',
            'available_to' => '15:00:00',
        ]);

        $service = app(AppointmentAvailabilityService::class);

        $this->expectException(ValidationException::class);

        $service->assertBookable($clinic, $doctor, CarbonImmutable::parse('2026-06-05 16:30:00'));
    }
}