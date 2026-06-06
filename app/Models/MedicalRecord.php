<?php

namespace App\Models;

use Database\Factories\MedicalRecordFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @use HasFactory<MedicalRecordFactory> */
class MedicalRecord extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke model Doctor
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relasi ke model Patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relasi ke model Appointment
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}