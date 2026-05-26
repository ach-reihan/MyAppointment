<?php

namespace App\Models;

use Database\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @use HasFactory<PatientFactory> */
class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];
}
