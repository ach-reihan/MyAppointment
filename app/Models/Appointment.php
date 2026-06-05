<?php

namespace App\Models;

use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @use HasFactory<AppointmentFactory> */
class Appointment extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'appointment_datetime' => 'datetime',
        ];
    }
}
