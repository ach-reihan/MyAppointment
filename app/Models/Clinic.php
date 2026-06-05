<?php

namespace App\Models;

use Database\Factories\ClinicFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** @use HasFactory<ClinicFactory> */
class Clinic extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = [];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'clinic_doctor')
            ->withPivot(['available_from', 'available_to']);
    }
}
