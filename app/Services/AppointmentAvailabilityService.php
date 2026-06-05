<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Doctor;
use Carbon\CarbonInterface;
use Illuminate\Validation\ValidationException;

class AppointmentAvailabilityService
{
    public function assertBookable(Clinic $clinic, Doctor $doctor, CarbonInterface $appointmentAt): void
    {
        $clinicStart = $this->minutesFromTime($clinic->opens_at);
        $clinicEnd = $this->minutesFromTime($clinic->closes_at);

        if ($clinicStart === null || $clinicEnd === null) {
            throw ValidationException::withMessages([
                'appointment_datetime' => 'Clinic availability is not configured.',
            ]);
        }

        if (! $this->isWithinWindow($appointmentAt, $clinicStart, $clinicEnd)) {
            throw ValidationException::withMessages([
                'appointment_datetime' => 'Selected time is outside clinic opening hours.',
            ]);
        }

        $doctorClinic = $doctor->clinics()
            ->whereKey($clinic->getKey())
            ->first();

        $doctorStart = $this->minutesFromTime($doctorClinic?->pivot?->available_from);
        $doctorEnd = $this->minutesFromTime($doctorClinic?->pivot?->available_to);

        if ($doctorStart === null || $doctorEnd === null) {
            throw ValidationException::withMessages([
                'appointment_datetime' => 'Doctor availability for this clinic is not configured.',
            ]);
        }

        if (! $this->isWithinWindow($appointmentAt, $doctorStart, $doctorEnd)) {
            throw ValidationException::withMessages([
                'appointment_datetime' => 'Selected time is outside doctor availability.',
            ]);
        }
    }

    private function isWithinWindow(CarbonInterface $appointmentAt, int $startMinutes, int $endMinutes): bool
    {
        $minutes = ((int) $appointmentAt->format('H')) * 60 + (int) $appointmentAt->format('i');

        return $minutes >= $startMinutes && $minutes <= $endMinutes;
    }

    private function minutesFromTime(string|null $time): ?int
    {
        if ($time === null || $time === '') {
            return null;
        }

        [$hours, $minutes] = array_map('intval', explode(':', substr($time, 0, 5)));

        return $hours * 60 + $minutes;
    }
}